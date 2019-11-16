@php
    $form=$lead['form'];
    $data=$lead['lead'];

@endphp

{{ $form->title }}

@foreach($data as $index => $field)
    {{ trans('idownload::suscriptors.mail.'.$index) }} :{{ $field }}
@endforeach
