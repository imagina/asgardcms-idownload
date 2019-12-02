@extends('idownload::frontend.emails.mainlayout')
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


@section('content')
  <div id="contend-mail" class="p-3">
    <h1>{{ $form->title }}</h1>
    <br>
    <div>
        {{ trans('idownload::idownloads.notification.admin') }}
    </div>
    <div style="margin-bottom: 5px">
        {!! str_replace($search,$replace,setting('idownload::mail-admin-content',locale())) !!}
    </div>
    <div style="margin-bottom: 5px">
      @foreach($data as $index => $field)
        <p class="px-3"><strong>{{ trans('idownload::suscriptors.mail.'.$index) }}:</strong> {!! $field !!} </p>
      @endforeach
        <p class="px-3"><strong>{{ trans('idownload::suscriptors.mail.title') }}:</strong> {!! $form->title !!} </p>
        <p class="px-3"><strong>{{ trans('idownload::suscriptors.mail.description') }}:</strong> {!! $form->description !!} </p>
    </div>
  </div>
@stop
