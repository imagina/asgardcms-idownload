@extends('layouts.master')

@section('meta')
    @include('idownload::frontend.partials.downloads.metas')
@stop

@section('title')
    {{ $download->title }} | @parent
@stop

@section('content')
    @php
        $locale = app()->getLocale();
    @endphp
   <div class="page blog single single-{{$category->slug}} single-{{$category->id}}">
        <div class="container" id="body-wrapper">
           <div class="row">
               <div class="col-12">
                   @include('partials.notifications')
               </div>
           </div>
            <div class="row">
                <div class="col-xs-12 col-sm-9 column1">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bgimg">
                                {{--<img class="image img-responsive" src="{{url($download->mainimage->path)}}"
                                     alt="{{$download->title}}"/>--}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="content col-xs-12" style="margin-bottom: 30px">
                            <h2>{{ $download->title }}</h2>
                            {!! $download->description !!}
                        </div>
                        <div class="col-12">
                            {{ Form::open(['route' => [$locale.'.idownload.send',$download->id], 'method'=>'PUT']) }}
                                <div class="row">
                                    <div class="col-sm-6">
                                        {{ Form::label('full_name', trans('idownload::suscriptors.form.fullName')) }}
                                        {{ Form::text('full_name','',['class'=>'form-control','required'=>true])  }}
                                    </div>
                                    <div class="col-sm-6">
                                        {{ Form::label('email', trans('idownload::suscriptors.form.email')) }}
                                        {{ Form::email('email','',['class'=>'form-control','required'=>true])  }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        {{ Form::label('phone', trans('idownload::suscriptors.form.phone')) }}
                                        {{ Form::text('phone','',['class'=>'form-control'])  }}
                                    </div>
                                    <div class="col-sm-6">
                                        {{ Form::label('comment', trans('idownload::suscriptors.form.comment')) }}
                                        {{ Form::textarea('comment','',['class'=>'form-control','rows'=>2])  }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        {{--<div class="g-recaptcha" data-sitekey="6LcBmsIUAAAAAIFex6vUBmJHVI7mL3zH2pS0exWU"></div>--}}
                                        {!! app('captcha')->display($attributes = ['data-sitekey'=>Setting::get('iforms::api'),'data-callback'=>"checkRecaptcha",'data-expired-callback'=>"disableButton"]) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-right" style="margin-top: 15px">
                                        <button id="sendBtn" class="btn btn-primary" disabled type="submit">{{ trans('idownload::suscriptors.button.send') }}</button>
                                    </div>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-3 column2">
                    <div class="sidebar-revista">
                        <div class="cate">
                            <h3>Categorias</h3>

                            <div class="listado-cat">
                                <ul>
                                    @if(isset($categories))
                                        @foreach($categories as $index=>$category)
                                            <li><a href="{{route($locale.'.idownload.category',[$category->slug])}}">{{$category->title}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    @parent
    @include('idownload::frontend.partials.downloads.script')
@stop
