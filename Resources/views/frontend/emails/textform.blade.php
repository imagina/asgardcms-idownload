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

{{ $form->title }}

{{ strip_tags(str_replace($search,$replace,setting('idownload::mail-subscriber-content',locale()))) }}

{{ trans('idownload::downloads.button.download_link') }}: {{ $form->download_file->path }}
