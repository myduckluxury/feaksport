<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable {
    use Queueable, SerializesModels;

    public $data; // Định nghĩa biến data để dùng trong view

    public function __construct($data) {
        $this->data = $data; // Gán dữ liệu vào biến
    }

    public function build() {
        return $this->subject('Thông tin liên hệ mới')
                    ->view('client.emails.contact')
                    ->with(['data' => $this->data]); // Truyền data sang view
    }
}