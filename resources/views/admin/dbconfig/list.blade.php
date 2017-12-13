@extends('layouts.admin.main',['request' => $request])
@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart-o fa-fw"></i> {{ trans('dbconfig.custom_config_list') }}</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-default btn-sm go_back_history">{{ trans('labels.buttons.go_back') }}</button>
                        @if(ViewsHelper::hasAccessTo('delete'))
                        <a class="btn btn-sm btn-danger" id="config_delete_rows" href="{{ url('admin/dbconfig/delete') }}">
                            <i class="fa fa-trash-o"></i>
                            {{ trans('labels.buttons.delete') }}
                        </a>
                        @endif
                        @if(ViewsHelper::hasAccessTo('add'))
                        <a class="btn btn-sm btn-success " id="openAddNewConfigFrm" href="#">{{ trans('dbconfig.buttons.add_new') }}</a>
                        @endif
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div id="config_list_cont">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>

<div class="modal fade" id="add_new_config_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" name="addNewConfigFrm" id="addNewConfigFrm">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('dbconfig.add_new') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="def_key">{{ trans('dbconfig.labels.config_slug') }}</label>
                        <input type="text" class="form-control" id="def_key" name="def_key">
                    </div>
                    <div class="form-group">
                        <label for="def_value">{{ trans('dbconfig.labels.config_value') }}</label>
                        <textarea class="form-control" id="def_value" name="def_value" rows="5" ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('labels.buttons.close') }}</button>
                    <button type="submit" id="submitConfigFrm" name="submitConfigFrm" class="btn btn-success">{{ trans('labels.buttons.add') }}</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



@stop
@section("styles")
<link rel="stylesheet" type="text/css" href="{{ ViewsHelper::css('toggle/bootstrap-toggle.min') }}"/>
@stop
@section("scripts")
<script type="text/javascript" src="{{ ViewsHelper::js('admin/plugins/jQueryUI/jquery-ui.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/iCheck/icheck.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/toggle/bootstrap-toggle.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/dbconfig/list') }}"></script>
@stop