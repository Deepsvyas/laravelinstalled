@extends('layouts.admin.main',['request' => $request])

@section('content')
<section class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart-o fa-fw"></i> {{ trans('role.role_permission_relation') }}</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-default btn-sm go_back_history">{{ trans('labels.buttons.go_back') }}</button>
                        @if(ViewsHelper::hasAccessTo('add')) 
                        <a class="btn btn-sm btn-warning" href="{{ url('admin/permission/addnew') }}">Add New Permission</a>
                        <a class="btn btn-sm btn-success" href="{{ url('admin/role/addnew') }}">Add New Role</a>
                        @endif
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>

                                </th>
                                @foreach($roles as $key => $data)
                                <th class="text-center">
                                    {{ $data->role_title }}
                                </th>
                                @endforeach
                            </tr>
                            @foreach($permission as $row)
                            <tr>
                                <th class="text-center">
                                    {{ $row->permission_title }}
                                </th>
                                @foreach($roles as $key => $data)
                                <td class="text-center">
                                    <?php
                                    $disabled = "";
                                    if ($data->role_slug == 'super_admin') {
                                        $disabled = "disabled";
                                    }
                                    ?>
                                    <input type="checkbox" <?php echo $disabled; ?> class="role_per_isset"<?php if ($data->isChecked($data->role_id, $row->permission_id)) echo 'checked="checked"'; ?> data-role="{{ $data->role_id }}" data-permission="{{ $row->permission_id }}" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="Yes" data-off="No">
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /.row -->
</section>
@stop

@section("scripts")
<link rel="stylesheet" type="text/css" href="{{ ViewsHelper::css('toggle/bootstrap-toggle.min') }}"/>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/toggle/bootstrap-toggle.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/role/role_permission_list') }}"></script>
@stop
