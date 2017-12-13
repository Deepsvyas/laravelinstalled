@extends('layouts.admin.main',['request' => $request])

@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart-o fa-fw"></i> Role List</h3>
                    <div class="box-tools pull-right">
                        @if(ViewsHelper::hasAccessTo('delete')) 
                        <a class="btn btn-sm btn-danger" id="delete_rows" href="{{ url('admin/role/deleterole')}}">
                            <i class="fa fa-trash-o"></i>
                            delete
                        </a>
                        @endif
                        @if(ViewsHelper::hasAccessTo('add')) 
                        <a class="btn btn-sm btn-success " href="{{ url('admin/role/addnew') }}">Add New Role</a>
                        @endif
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 10px"><input type="checkbox" id="checkallitem"></th>
                                <th>
                                    Role Title
                                </th>
                                <th>
                                    Role slug
                                </th>
                                <th>
                                    Role level
                                </th>
                                <th>
                                    Description
                                </th>
                                <th>
                                    Created at
                                </th>
                                <th>
                                    Updated at
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                            @foreach($data as $row)
                            <tr>
                                <td><input name="selected[]" class="actionsid square-blue" value="<?php echo $row->role_id; ?>" type="checkbox"></td>
                                <td>
                                    {{ $row->role_title }}
                                </td>
                                <td>
                                    {{ $row->role_slug }}
                                </td>
                                <td>
                                    {{ $row->role_level }}
                                </td>
                                <td>
                                    {{ $row->description }}
                                </td>
                                <td>
                                    {{CommonHelper::timestampToDate($row->created_at) }}
                                </td>
                                <td>
                                    {{CommonHelper::timestampToDate($row->updated_at)}}
                                </td>
                                <td>
                                    <a class="btn btn-info btn-xs" href="{{ url('admin/role/edit/'.$row->role_id) }}">Edit</a>
                                </td>
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
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/iCheck/icheck.min') }}"></script>
@stop