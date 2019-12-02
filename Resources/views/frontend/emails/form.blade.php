@extends('idownload::frontend.emails.mainlayout')
@php
  $form=$lead['form'];
  $data=$lead['lead'];
  $mailContent = ['nombre' => $data->full_name];
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
    <div style="margin-bottom: 5px">
      {!! str_replace($search,$replace,setting('idownload::mail-subscriber-content',locale())) !!}
    </div>
    <div style="margin-bottom: 5px">
        <p class="px-3"><button class="btn btn-danger"><a href="{{ $form->download_file->path }}" target="_blank">{{ trans('idownload::downloads.button.download_link') }}</a></button></p>
    </div>
  </div>
@stop
