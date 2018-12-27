<?php

namespace App\Http\Controllers\Home;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('blog.contact.index');
    }

    public function sendContactInfo(ContactRequest $request)
    {
        $data = $request->only('name', 'email', 'phone');
        $data['messageLines'] = explode("\n", $request->get('message'));

        Mail::to(config('blog.email'))->send(new ContactMail($data));

        return back()->with('success', '邮件发送成功，我们将尽快确认');
    }
}
