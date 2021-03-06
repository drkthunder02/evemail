<?php

namespace EVEMail\Jobs;

use EVEMail\Token;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use EVEMail\Http\Controllers\MailController;
use EVEMail\Http\Controllers\TokenController;

class GetCharacterMailHeaders implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $token, $mail, $character_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($character_id)
    {
        $this->mail = new MailController();
        $this->token = new TokenController();
        $this->character_id = $character_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->mail->get_character_mail_headers($this->character_id);
        $this->mail->check_for_unknown_headers($this->character_id);
        //$this->mail->process_queue();
    }

    public function __destruct(){
        foreach (get_class_vars(__CLASS__) as $clsVar => $_) {
            unset($this->$clsVar);
        }
    }
}
