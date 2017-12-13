@extends('layouts.admin.main',['request' => $request])
@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info user_list_wrap">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart-o fa-fw"></i> User List</h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-sm btn-default go_back_history">
                            <i class="fa fa-arrow-left"></i> Go Back
                        </a>
                        <a class="btn btn-sm btn-default refresh_list">
                            <i class="fa fa-refresh"></i>
                        </a>
                        @if(ViewsHelper::hasAccessTo('users_delete')) 
                        <a class="btn btn-sm btn-danger"  id="user_delete_rows" href="{{ url('admin/users/deleteusers') }}">
                            <i class="fa fa-trash-o"></i>
                            Delete
                        </a>
                        @endif
                        @if(ViewsHelper::hasAccessTo('users_add')) 
                        <a class="btn btn-success btn-sm" href="{{ url('admin/users/addnew') }}"><i class="fa fa-plus"></i> Add New </a>
                        @endif
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div id="user_list_cont">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
@stop
@section("styles")
<link rel="stylesheet" type="text/css" href="{{ ViewsHelper::css('toggle/bootstrap-toggle.min') }}"/>
@stop
@section("scripts")
<script>
var role_slug = "{{ $role_slug }}";
</script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/iCheck/icheck.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/toggle/bootstrap-toggle.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/user/userlist') }}"></script>


@stop
