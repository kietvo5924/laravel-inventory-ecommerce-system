<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from($this->data['email'], $this->data['name']) // Lấy email và tên từ data
            ->to('StockManager@gmail.com') // Địa chỉ nhận email
            ->subject('Liên Hệ Mới Từ ' . $this->data['name'])
            ->view('emails.contact')
            ->with('data', $this->data);
    }
}
