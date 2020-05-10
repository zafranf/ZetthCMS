<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

class ActionController extends Controller
{
    use \ZetthCore\Traits\MainTrait;

    public function like(Request $r, $like = true)
    {
        /* validate request */
        if (!$r->ajax() || !app('user')) {
            abort(403);
        }

        $post = \App\Models\Post::where('slug', $r->input('post'))->with('likes_user')->first();
        if ($post) {
            $likes = $post->likes_user;
            if ($likes) {
                if ($likes->like) {
                    $post->decrement('liked');
                    if (!$like) {
                        $like_str = 'ubah suka jadi tidak suka';
                        $post->increment('disliked');

                        /* update user like post */
                        $likes->like = 'no';
                        $likes->save();
                    } else {
                        $like_str = 'hapus suka';
                        $likes->delete();
                    }
                } else {
                    $post->decrement('disliked');
                    if ($like) {
                        $like_str = 'ubah tidak suka jadi suka';
                        $post->increment('liked');

                        /* update user like post */
                        $likes->like = 'yes';
                        $likes->save();
                    } else {
                        $like_str = 'hapus tidak suka';
                        $likes->delete();
                    }
                }
            } else {
                if ($like) {
                    $like_str = 'suka';
                    $post->increment('liked');
                } else {
                    $like_str = 'tidak suka';
                    $post->increment('disliked');
                }

                /* save user like post */
                \App\Models\Like::create([
                    'likeable_type' => 'App\Models\Post',
                    'likeable_id' => $post->id,
                    'user_id' => app('user')->id,
                    'like' => $like,
                    'site_id' => app('site')->id,
                ]);
            }

            /* update post */
            $post->save();

            /* clear cache */
            \Cache::forget('_getPostscompletedesc' . $r->input('post') . '11' . app('site')->id);

            /* save activity */
            $this->activityLog('[~name] ' . $like_str . ' artikel "' . $post->slug . '"');
        }

        return response()->json([
            'status' => true,
            'data' => [
                'like' => $post->liked ?? 0,
                'dislike' => $post->disliked ?? 0,
            ],
        ]);
    }

    public function dislike(Request $r)
    {
        return $this->like($r, false);
    }

    public function comment(Request $r)
    {
        /* get post */
        $post = \App\Models\Post::articles()->active()->where('slug', $r->input('slug'))->first();
        if (!$post) {
            abort(404);
        }

        /* save comment */
        $comment = new \App\Models\Comment;
        $comment->name = $r->input('name') ?? \Auth::user()->fullname;
        $comment->email = $r->input('email') ?? \Auth::user()->email;
        $comment->content = '<p>' . nl2br(strip_tags($r->input('comment'))) . '</p>';
        $comment->parent_id = $r->input('reply_to') ?? null;
        $comment->notify = $r->input('notify') ?? 'no';
        $comment->read = 'no';
        $comment->status = 'inactive';
        $comment->is_owner = 'no';
        $comment->commentable_type = 'App\Models\Post';
        $comment->commentable_id = $post->id;
        $comment->created_by = \Auth::user()->id;
        $comment->site_id = app('site')->id;
        $comment->save();

        /* send notif to parent */
        if ($comment->parent) {
            $parent = $comment->parent;
            $topparent = \App\Models\Comment::find($parent->parent_id ?? $parent->id);
            $data = [
                'post' => $post,
                'parent' => $topparent,
                'comment' => $comment,
            ];
            \App\Jobs\CommentReply::dispatch($data);
        }

        /* clear cache */
        \Cache::forget('_getPostscompletedesc' . $post->slug . '11' . app('site')->id);

        /* save activity */
        $this->activityLog('[~name] memberikan komentar untuk artikel "' . $post->slug . '"');

        return redirect(url(config('path.post') . "/" . $post->slug . "#comments"))->with('success', true);
    }

    public function contact(Request $r)
    {
        /* set validation */
        $this->validate($r, [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required',
            'g-recaptcha-response' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!validateCaptcha($value)) {
                        $fail('Invalid g-recaptcha-response');
                    }
                },
            ],
        ]);

        /* save contact */
        $inbox = new \App\Models\Inbox;
        $inbox->name = $r->input('name');
        $inbox->email = $r->input('email');
        $inbox->phone = $r->input('phone');
        $inbox->site = $r->input('site');
        $inbox->subject = $r->input('subject');
        $inbox->message = $r->input('message');
        $inbox->read = 'no';
        $inbox->status = 'active';
        $inbox->site_id = app('site')->id;
        $inbox->save();

        /* send email to support */
        $r->merge([
            'content' => $r->input('message'),
        ]);

        /* send mail */
        \Mail::to(explode(',', env('MAIL_NOTIF')))->queue(new \App\Mail\ContactForm($r->input()));

        $data = json_encode($r->except(['subject', 'message', 'content', 'g-recaptcha-response', '_token']));
        $expire = now()->addYear()->getTimestamp();
        $cookie = cookie('contact', $data, $expire);

        /* save activity */
        $this->activityLog($inbox->email . ' mengirim pesan dari formulir kontak');

        return redirect(route("web.contact"))
            ->with('success', 'Pesan berhasil dikirim.')
            ->withCookie($cookie);
    }

    public function share(Request $r, $slug, $socmed)
    {
        /* get post */
        $post = \App\Models\Post::active()->posts()->where('slug', $slug)->first();
        if (!$post) {
            abort(404);
        }

        /* +1 shared */
        $post->increment('shared');
        $post->save();

        /* return to socmed url */
        $posturl = url(config('path.post') . '/' . $post->slug);
        if ($socmed == 'facebook') {
            $url = 'https://www.facebook.com/sharer/sharer.php?u=' . $posturl . '&src=sdkpreparse';
        } else if ($socmed == 'twitter') {
            $url = 'https://twitter.com/intent/tweet?text=' . $post->title . ' ' . $posturl;
        } else if ($socmed == 'whatsapp') {
            $url = 'https://api.whatsapp.com/send?text=' . $post->title . ' ' . $posturl;
        } else if ($socmed == 'telegram') {
            $url = 'https://telegram.me/share/url?url=' . $posturl . '&text=' . $post->title;
        } else {
            abort(404);
        }

        return redirect($url);
    }

    public function subscribe(Request $r)
    {
        $this->validate($r, [
            'email' => ['required', 'email'],
        ]);

        $subscriber = \App\Models\Subscriber::firstOrCreate([
            'email' => $r->input('email'),
        ], [
            'token' => md5($r->input('email') . uniqid() . strtotime('now') . env('APP_KEY')),
            'status' => 'active',
        ]);

        /* save activity */
        $this->activityLog($r->input('email') . ' mendaftar jadi pelanggan');

        return redirect()->back()->with('subscribed', true);
    }
}
