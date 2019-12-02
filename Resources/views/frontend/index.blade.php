@extends('layouts.master')
@section('meta')
    @include('idownload::frontend.partials.category.metas')
@stop
@section('title')
    {{trans('idownload::downloads.title.downloads')}} | @parent
@stop
@section('content')
    @php
        $locale = app()->getLocale();
    @endphp
    <div class="docs-category-all">
        <div class="container">
            <div class="row">
                <div class="col-md-12">&nbsp;</div>
            </div>
            <div class="row">
                {!! Form::open(['route' => ['frontend.idownload.search'], 'method' => 'get', 'class' => 'col-md-12']) !!}
                    <div class="row">
                        <div class="col-md-10">
                            {!! Form::text("q", old("q"), ['class' => 'form-control', 'placeholder' => trans('idownload::downloads.messages.searchFor')]) !!}
                        </div>
                       <div class="col-md-2">
                           <input type="submit" class="btn btn-success btn-block" value="{{trans('idownload::downloads.messages.search')}}">
                       </div>
                   </div>
               {!! Form::close() !!}
                <div class="col-md-12">
                    <h1 class="my-4">
                        {{isset($category) ? $category->title : trans('idownload::downloads.title.downloads')}}
                    </h1>
                    <hr />
                </div>
                <div class="col-md-12">
                    <div class="row">
                        @if (count($downloads))
                            @foreach($downloads as $download)
                                <div class="col-sm-4">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">{!! $download->title !!}</h5>
                                            <p class="card-text">{{ substr($download->description,0,40) }}...</p>
                                            <a href="{{ route($locale.'.idownload.download',['categorySlug'=>$download->category->slug,'downloadSlug'=>$download->slug]) }}"
                                               class="btn btn-primary btn-block">
                                                {{ trans('idownload::downloads.button.download') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-sm-12">
                                <div class="pagination justify-content-center mb-4 pagination paginacion-blog row">
                                    <div class="pull-right">
                                        {{$downloads->links('pagination::bootstrap-4')}}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-xs-12 con-sm-12">
                                <div class="white-box">
                                    <h3>Ups... :(</h3>
                                    <h1>404 descarga no encontrada</h1>
                                    <hr>
                                    <p style="text-align: center;">
                                        No hemos podido encontrar el Contenido que estás
                                        buscando.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
