<?php

    namespace App\Mail;

    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class SendVerificationCodeMail extends Mailable
    {
        use Queueable, SerializesModels;

        /**
         * Create a new message instance.
         *
         * @return void
         */
        public $code;

        public function __construct($code)
        {
            $this->code = $code;
        }

        /**
         * Build the message.
         *
         * @return $this
         */
        public function build()
        {
            // return $this->from(config(['mail.mailers.smtp.username']))
            return $this->from('admin@gmail.com')
                ->subject('Verification Code')
                ->view('emails.send_verification_mail', [
                    'code' => $this->code,
                ]);
        }
    }
