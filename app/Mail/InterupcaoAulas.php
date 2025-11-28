<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InterupcaoAulas extends Mailable {

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $subject = "Notificação";
    private $channel = ['email'];
    
    public function __construct($subject, $channel) {
        $this->subject = $subject;
        $this->channel = $channel;        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('view.name');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        #pode ser [mail , database , broadcast , nexmo , slack] channels
        return $this->channel;
    }

    public function toMail($notifiable) {
        return (new MailMessage)->subject("Reunião Escolar 2 Semetre")->markdown('notificacao.invoice', ['encaregado' => $notifiable]);
    }

}
