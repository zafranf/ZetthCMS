<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;

class ActionController extends Controller
{
    use \ZetthCore\Traits\MainTrait;

    public function _save_intermx($id = 0)
    {
        $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
        $hosts = $this->init['hosts'];

        foreach ($hosts as $v) {
            if (str_contains($referrer, $v)) {
                $params = Interm::where('interm_host', $v)->first()->interm_param;
                $param = explode($params . "=", $referrer);
                if (!isset($param[1])) {
                    return;
                }
                $texts = explode("&", $param[1]);
                $text = $texts[0];

                $check = IntermData::where('interm_host', $v)->
                    where('interm_text', $text)->
                    where('app_id', Session::get('app')->app_id)->
                    where('post_id', $id)->
                    first();
                if ($check) {
                    $save = IntermData::find($check->interm_id);
                    $save->interm_count = $check->interm_count + 1;
                    $save->save();
                } else {
                    $save = new IntermData;
                    $save->interm_host = $v;
                    $save->interm_text = $text;
                    $save->interm_count = 1;
                    $save->post_id = $id;
                    $save->app_id = Session::get('app')->app_id;
                    $save->save();
                }
                return;
            }
        }
    }

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
                        $likes->like = 0;
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
                        $likes->like = 1;
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
                \App\Models\PostLike::create([
                    'post_id' => $post->id,
                    'user_id' => app('user')->id,
                    'like' => $like,
                ]);
            }

            /* update post */
            $post->save();

            /* clear cache */
            \Cache::forget('_getPostscompletedesc' . $r->input('post') . '11');

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
        $post = \App\Models\Post::articles()->where('slug', $r->input('slug'))->first();
        if (!$post) {
            abort(404);
        }

        /* save comment */
        $comment = new \App\Models\PostComment;
        $comment->name = \Auth::user()->fullname;
        $comment->email = \Auth::user()->email;
        $comment->comment = '<p>' . nl2br(strip_tags($r->input('comment'))) . '</p>';
        $comment->parent_id = $r->input('reply_to') ?? null;
        $comment->post_id = $post->id;
        $comment->notify = bool($r->input('notify')) ? 1 : 0;
        $comment->read = 0;
        $comment->status = 0;
        $comment->is_owner = 0;
        $comment->created_by = \Auth::user()->id;
        $comment->save();

        /* clear cache */
        \Cache::forget('_getPostscompletedesc' . $post->slug . '11');

        /* save activity */
        $this->activityLog('[~name] memberikan komentar untuk artikel "' . $post->slug . '"');

        return redirect(url(env('SINGLE_POST_PATH', 'post') . "/" . $post->slug . "#komentar"))->with('success', true);
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
        $inbox->read = 0;
        $inbox->status = 1;
        $inbox->save();

        /* send email to support */
        $r->merge([
            'content' => $r->input('message'),
        ]);

        /* send mail */
        $this->sendMail([
            'view' => $this->getTemplate() . '.emails.contact',
            'data' => $r->input(),
            'from' => env('MAIL_USERNAME', 'no-reply@' . env('APP_DOMAIN')),
            'to' => explode(',', env('MAIL_NOTIF')),
            'subject' => '[' . env('APP_NAME') . '] Pesan masuk dari ' . $r->input('name'),
        ]);

        $data = json_encode($r->except(['message', 'content']));
        $expire = now()->addYear()->getTimestamp();
        $cookie = cookie('contact', $data, $expire);

        return redirect("contact")
            ->with('success', 'Pesan berhasil dikirim.')
            ->withCookie($cookie);
    }

    public function share(Request $r, $slug, $socmed)
    {
        /* get post */
        $post = \App\Models\Post::where('slug', $slug)->first();
        if (!$post) {
            abort(404);
        }

        /* +1 shared */
        $post->increment('shared');
        $post->save();

        /* return to socmed url */
        $posturl = url('/' . env('SINGLE_POST_PATH') . '/' . $post->slug);
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
}
