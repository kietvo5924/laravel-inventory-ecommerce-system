<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendContactEmail(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ];

        Mail::to('StockManager@gmail.com')->send(new ContactMail($data));

        return redirect()->route('contact')->with('success', 'Tin nhắn gửi thành công, Kiểm tra email để xem phản hồi!');
    }
}
