@php
    $form=$lead['form'];
    $data=$lead['lead'];

    $mailContent = ['nombre_sitio' => setting('core::site-name')];
    $search = [];
    $replace = [];
    foreach($mailContent as $index=>$value){
      $search[] = '{'.$index.'}';
      $replace[] = $value;
    }

@endphp

{{ $form->title }}

{{ strip_tags(str_replace($search,$replace,setting('idownload::mail-admin-content',locale()))) }}

@foreach($data as $index => $field)
    {{ trans('idownload::suscriptors.mail.'.$index) }} :{{ $field }}
@endforeach
    {{ trans('idownload::suscriptors.mail.title') }} :{{ $form->title }}
    {{ trans('idownload::suscriptors.mail.description') }} :{{ strip_tags($form->description) }}
