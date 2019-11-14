<?php

namespace Modules\Idownload\Events\Handlers;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;

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
      $subscription = $event->entity;
      $download = $event->data['download'];
      $sender = $this->setting->get('core::site-name');
      $subject = $download->title . " " . trans('iforms::forms.messages.from') . " " . $sender;
      $view = ['iforms::frontend.emails.form','iforms::frontend.emails.textform'];

      $emails = !empty($this->setting->get('isite::emails'))?json_decode($this->setting->get('isite::emails'),true):[env('MAIL_FROM_ADDRESS')];

      if (isset($subscription->email) && !empty($subscription->email)) {
        array_push($emails, $subscription->email);
      }

      $this->mail->to($emails)->send(new Sendmail(['lead'=>$subscription,'form'=>$download], $subject, $view));
    }
}
