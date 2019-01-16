<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\ContactRequest;
use App\Jobs\SendContactEmail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends CommonController
{
    public function showForm()
    {
        return view('blog.'. $this->layout .'.contact.index');
    }

    public function sendContactInfo(ContactRequest $request)
    {
        $data = $request->only('name', 'email', 'phone');
        $data['messageLines'] = explode("\n", $request->get('message'));

        //Mail::to(config('blog.email'))->send(new ContactMail($data));
        // 将邮件发送任务推送到队列
        //Mail::to(config('blog.email'))->queue(new ContactMail($data));

        $this->dispatch(new SendContactEmail($data));
        return back()->with('success', '邮件发送成功，我们将尽快确认');
    }
}
