<?php

namespace Modules\Idownload\Events\Handlers;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use Modules\Idownload\Emails\Sendmail;
use Modules\Media\Entities\File;
use Illuminate\Support\Facades\Auth;

class HandlerSucriptorWasCreated
{

    private $mail;
    private $setting;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mail)
    {
      $this->mail = $mail;
      $this->setting = app('Modules\Setting\Contracts\Setting');
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
      /*Slim descomentar para probar*/
      try {
        $suscriptor = $event->suscriptor;
        $suscriptor2 = $suscriptor->toArray();
        unset($suscriptor2['id'],$suscriptor2['created_at'],$suscriptor2['updated_at'],$suscriptor2['download_id']);
        $download = $event->data['download'];
        \Log::info('Sending email - '.$suscriptor->email);
        $sender = $this->setting->get('core::site-name');
        $subject = $download->title . " " . $sender;
        $view = ['idownload::frontend.emails.form', 'idownload::frontend.emails.textform'];
        $dumpEmails = json_decode($this->setting->get('isite::emails'));
        $emails2 = [];
        foreach ($dumpEmails as $dumpEmail){
          $emails2[] = $dumpEmail->value;
        }
        $emails2 =  count($emails2)>0?$emails2:[env('MAIL_FROM_ADDRESS')];
        $emails[]= $suscriptor['email'];

        $view2 = ['idownload::frontend.emails.admin', 'idownload::frontend.emails.textadmin'];

        $this->mail->to($emails)->send(new Sendmail(['lead' => $suscriptor, 'form' => $download], $subject, $view));
        unset($suscriptor['download']);
        $subject2 =  trans('idownload::idownloads.notification.admin'). ': '. $download->title . " " . $sender;
        $this->mail->to($emails2)->send(new Sendmail(['lead' => $suscriptor2, 'form' => $download], $subject2, $view2));

        \Log::info('Successful email - '.$suscriptor->email);
      }catch(\Exception $e){
        \Log::error($e->getMessage().' '.$e->getFile().' '.$e->getLine());
      }
    }
}
