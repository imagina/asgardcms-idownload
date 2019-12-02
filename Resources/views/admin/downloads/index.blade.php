@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('idownload::downloads.title.downloads') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('idownload::downloads.title.downloads') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.idownload.download.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('idownload::downloads.button.create download') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="10%">{{ trans('idownload::downloads.table.id') }}</th>
                                <th>{{ trans('idownload::downloads.table.title') }}</th>
                                <th width="30%">{{ trans('idownload::downloads.table.category') }}</th>
                                <th width="5%">{{ trans('idownload::downloads.table.file') }}</th>
                                <th width="10%">{{ trans('core::core.table.created at') }}</th>
                                <th width="10%" data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($downloads)): ?>
                            <?php foreach ($downloads as $download): ?>
                            <tr>
                                <td>
                                    <a href="{{ route('admin.idownload.download.edit', [$download->id]) }}">
                                        {{ $download->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.idownload.download.edit', [$download->id]) }}">
                                        {{ $download->title }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.idownload.download.edit', [$download->id]) }}">
                                        {{ $download->category->title }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url($download->download_file->path) }}" target="_blank">
                                        <i class="fa fa-file"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.idownload.download.edit', [$download->id]) }}">
                                        {{ $download->created_at }}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.idownload.download.edit', [$download->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.idownload.download.destroy', [$download->id]) }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('core::core.table.created at') }}</th>
                                <th>{{ trans('core::core.table.actions') }}</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('idownload::downloads.title.create download') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.idownload.download.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@endpush
