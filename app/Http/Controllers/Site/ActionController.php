<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use ZetthCore\Http\Controllers\SiteController;

class ActionController extends SiteController
{
    use \ZetthCore\Traits\MainTrait;

    public function index(Request $r, $slug)
    {

    }

    public function comment(Request $r)
    {
        $slug = $r->input('slug');
        $post = \ZetthCore\Models\Post::articles()->where('slug', $slug)->first();

        $comment = new \ZetthCore\Models\PostComment;
        $comment->name = $r->input('name');
        $comment->email = $r->input('email');
        $comment->site = $r->input('site');
        $comment->comment = $r->input('comment');
        $comment->parent_id = $r->input('reply_to') ?? 0;
        $comment->post_id = $post->id;
        $comment->read = 0;
        $comment->status = 0;
        $comment->save();

        $_POST['content'] = e($r->input('comment'));
        $this->activityLog('comment');

        $cookie = [
            'name' => $r->input('name'),
            'email' => $r->input('email'),
            'site' => $r->input('site'),
        ];

        return redirect(url("news/" . $slug . "#comments"))->with('success', 'Komentar berhasil dikirim. Komentar yang masuk akan dicek terlebih dahulu sebelum ditampilkan. Terima kasih ;)')->withCookie(cookie('comment', json_encode($cookie), 60 * 24 * 30));
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
        $inbox = new \ZetthCore\Models\Inbox;
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

        $this->sendMail([
            'view' => $this->getTemplate() . '.emails.inbox',
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
}
