@extends('layouts.admin.main',['request' => $request])

@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="panel-title">
                        <i class="fa fa-bar-chart-o fa-fw"></i> {{ trans('permission.edit_permission') }}
                    </h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-default btn-sm go_back_history">{{ trans('labels.buttons.go_back') }}</button>
                        @if(ViewsHelper::hasAccessTo('list')) 
                        <a class="btn btn-success btn-sm" href="{{ url('admin/permission') }}">{{ trans('permission.permission_list') }}</a>
                        @endif
                    </div>
                </div><!-- /.box-header -->
                <div class="height10"></div>
                <div class="box-body">
                    <form role="form" name="editPermissionFrm" id="editPermissionFrm">
                        <div class="form-group">
                            <label for="permission_title">{{ trans('permission.labels.title') }}</label>
                            <input type="text" name="permission_title" id="permission_title" class="form-control" value="{{ $data->permission_title }}" />
                        </div>
                        <div class="form-group">
                            <label for="permission_slug">{{ trans('permission.labels.slug') }}</label>
                            <input type="text" name="permission_slug" id="permission_slug" class="form-control" value="{{ $data->permission_slug }}"/>
                        </div>
                        <div class="form-group">
                            <label for="permission_description">{{ trans('permission.labels.desc') }}</label>
                            <textarea name="permission_description" id="permission_description" class="form-control" />{{ $data->permission_description }}</textarea>
                        </div>
                        <button type="submit" id="submitFrm" name="submitFrm" class="btn btn-success">{{ trans('labels.buttons.submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
@stop

@section("scripts")
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/permission/edit') }}"></script>
@stop
<script>
var permission_id = "<?php echo $data->permission_id; ?>";
</script>