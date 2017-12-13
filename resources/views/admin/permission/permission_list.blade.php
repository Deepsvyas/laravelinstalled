@extends('layouts.admin.main',['request' => $request])

@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">

                <div class="box-header with-border">
                    <h3 class="panel-title">
                        <i class="fa fa-bar-chart-o fa-fw"></i> {{ trans('permission.permission_list') }}
                    </h3>
                    <div class="box-tools pull-right">
                        
                        <a class="btn btn-sm btn-danger" id="delete_rows" href="{{ url('admin/permission/deletepermission')}}">
                            <i class="fa fa-trash-o"></i>
                            {{ trans('labels.buttons.delete') }}
                        </a>
                        <a class="btn btn-sm btn-success " href="{{ url('admin/permission/addnew') }}">{{ trans('permission.buttons.add_new_permission') }}</a>
                    </div>
                </div><!-- /.box-header -->

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th style="width: 10px"><input type="checkbox" id="checkallitem"></th>
                                    <th>
                                        {{ trans('permission.labels.title') }}
                                    </th>
                                    <th>
                                        {{ trans('permission.labels.slug') }}
                                    </th>
                                    <th>
                                        {{ trans('permission.labels.desc') }}
                                    </th>
                                    <th>
                                        {{ trans('labels.created_at') }}
                                    </th>
                                    <th>
                                        {{ trans('labels.last_updated') }}
                                    </th>
                                    <th>
                                        {{ trans('labels.action') }}
                                    </th>
                                </tr>
                                @foreach($data as $row)
                                <tr>
                                    <td><input name="selected[]" class="actionsid square-blue" value="<?php echo $row->permission_id; ?>" type="checkbox"></td>
                                    <td>
                                        {{ $row->permission_title }}
                                    </td>
                                    <td>
                                        {{ $row->permission_slug }}
                                    </td>
                                    <td>
                                        {{ $row->permission_description }}
                                    </td>
                                    <td>
                                        {{CommonHelper::timestampToDate($row->created_at) }}
                                    </td>
                                    <td>
                                        {{CommonHelper::timestampToDate($row->updated_at)}}
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs" href="{{ url('admin/permission/edit/'.$row->permission_id) }}">Edit</a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            {!! $data->render() !!}

                        </div>
                    </div>
                </div>
            </div>
        
    </div>
    <!-- /.row -->
</section>
@stop

@section("scripts")
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/iCheck/icheck.min') }}"></script>
@stop