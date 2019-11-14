@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('idownload::suscriptors.title.suscriptors') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('idownload::suscriptors.title.suscriptors') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('idownload::suscriptors.table.id') }}</th>
                                <th>{{ trans('idownload::suscriptors.table.download') }}</th>
                                <th>{{ trans('idownload::suscriptors.table.fullName') }}</th>
                                <th>{{ trans('idownload::suscriptors.table.email') }}</th>
                                <th>{{ trans('idownload::suscriptors.table.phone') }}</th>
                                <th>{{ trans('idownload::suscriptors.table.comment') }}</th>
                                <th>{{ trans('idownload::suscriptors.table.download') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($suscriptors)): ?>
                            <?php foreach ($suscriptors as $suscriptor): ?>
                            <tr>
                                <td>
                                    <a href="{{ route('admin.idownload.suscriptor.edit', [$suscriptor->id]) }}">
                                        {{ $suscriptor->id }}
                                    </a>
                                </td>

                                <td>
                                    {{ $suscriptor->download->title }}  ({{ $suscriptor->download->id }})
                                </td>

                                <td>
                                    {{ $suscriptor->full_name }}
                                </td>

                                <td>
                                    {{ $suscriptor->email }}
                                </td>

                                <td>
                                    {{ $suscriptor->phone }}
                                </td>

                                <td>
                                    {{ $suscriptor->comment }}
                                </td>

                                <td>
                                    {{ $suscriptor->created_at }}
                                </td>

                                <td>
                                    {{ $suscriptor->created_at }}
                                </td>

                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>{{ trans('idownload::suscriptors.table.id') }}</th>
                                <th>{{ trans('idownload::suscriptors.table.download') }}</th>
                                <th>{{ trans('idownload::suscriptors.table.fullName') }}</th>
                                <th>{{ trans('idownload::suscriptors.table.email') }}</th>
                                <th>{{ trans('idownload::suscriptors.table.phone') }}</th>
                                <th>{{ trans('idownload::suscriptors.table.comment') }}</th>
                                <th>{{ trans('idownload::suscriptors.table.download') }}</th>
                                <th>{{ trans('core::core.table.created at') }}</th>

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
        <dd>{{ trans('idownload::suscriptors.title.create suscriptor') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.idownload.suscriptor.create') ?>" }
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
