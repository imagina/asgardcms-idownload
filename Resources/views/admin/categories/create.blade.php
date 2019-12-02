@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('idownload::categories.title.create category') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.idownload.category.index') }}">{{ trans('idownload::categories.title.categories') }}</a></li>
        <li class="active">{{ trans('idownload::categories.title.create category') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.idownload.category.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-xs-12 col-md-9">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('idownload::admin.categories.partials.create-fields', ['lang' => $locale])
                        </div>
                    @endforeach

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                        <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.idownload.category.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                    </div>
                </div>
            </div> {{-- end nav-tabs-custom --}}
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="col-xs-12 ">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <div class="form-group">
                            <label>{{trans('idownload::categories.title.categories')}}</label>
                        </div>
                    </div>
                    <div class="box-body">
                        <select class="form-control" name="parent_id">
                            <option value="0">
                                -
                            </option>
                            @if(count($categories))
                                @foreach ($categories as $cat)
                                    <option value="{{$cat->id}}"> {{$cat->title}}
                                    </option>
                                @endforeach
                            @endif
                        </select><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.idownload.category.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
@endpush
