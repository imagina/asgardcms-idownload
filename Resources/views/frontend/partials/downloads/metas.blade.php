<meta name="description" content="{{$download->description}}">
<!-- Schema.org para Google+ -->
<meta itemprop="name" content="{{$download->title}}">
<meta itemprop="description" content="{{$download->description}}">
<!-- Open Graph para Facebook-->
<meta property="og:title" content="{{$download->title}}"/>
<meta property="og:type" content="article"/>
<meta property="og:url" content="{{ route(app()->getLocale().'.idownload.download',['categorySlug'=>$category->slug,'downloadSlug'=>$download->slug]) }}"/>
<meta property="og:description" content="{{$download->description}}"/>
<meta property="og:site_name" content="{{Setting::get('core::site-name') }}"/>
<meta property="og:locale" content="{{config('asgard.idocs.config.oglocale')}}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{ Setting::get('core::site-name') }}">
<meta name="twitter:title" content="{{$download->title}}">
<meta name="twitter:description" content="{{$download->description}}">
<meta name="twitter:creator" content="{{Setting::get('idocs::twitter') }}">
