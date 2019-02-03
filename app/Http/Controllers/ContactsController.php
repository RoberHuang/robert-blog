<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Jobs\SendContactEmail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

/**
 * Class ContactsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ContactsController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->layout .'.contacts.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContactRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactRequest $request)
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
