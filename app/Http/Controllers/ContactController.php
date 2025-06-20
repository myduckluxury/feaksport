<?php

namespace App\Http\Controllers;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    // Hiển thị form liên hệ
    public function showForm()
    {
        return view('client.contact.contact'); 
    }

    // Xử lý gửi form
    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone'=> 'required|string|max:12',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ];

        // Gửi email
        Mail::to('cuongmanh1024@gmail.com')->send(new ContactMail((array) $request->all()));



        return back()->with('success', 'Cảm ơn bạn! Tin nhắn đã được gửi.');
    }
}