<?php

namespace Modules\Idownload\Events\Handlers;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use Modules\Idownload\Emails\Sendmail;
use Modules\Media\Entities\File;

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
        $suscriptor = $event->suscriptor->toArray();
        $download = $event->data['download'];
        \Log::info('Sending email - '.$suscriptor['email']);
        $suscriptor['download'] = "<a href='{$download->download_file->path}' target='_blank'>" . trans('idownload::downloads.button.download_link') . "</a>";
        $sender = $this->setting->get('core::site-name');
        $subject = $download->title . " " . $sender;
        $view = ['idownload::frontend.emails.form', 'idownload::frontend.emails.textform'];
        unset($suscriptor['id'],$suscriptor['download_id'],$suscriptor['created_at'],$suscriptor['updated_at']);
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
        $this->mail->to($emails2)->send(new Sendmail(['lead' => $suscriptor, 'form' => $download], $subject2, $view2));

        \Log::info('Successful email - '.$suscriptor['email']);
      }catch(\Exception $e){
        \Log::error($e->getMessage().' '.$e->getFile().' '.$e->getLine());
      }
    }
}
