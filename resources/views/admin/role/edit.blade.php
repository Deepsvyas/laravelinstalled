@extends('layouts.admin.main',['request' => $request])

@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="panel-title">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Edit Role
                    </h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-default btn-sm go_back_history">Go back</button>
                        @if(ViewsHelper::hasAccessTo('list')) 
                        <a class="btn btn-success btn-sm" href="{{ url('admin/role') }}">Role List</a>
                        @endif
                    </div>
                    <div class="height5"></div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" name="editRoleFrm" id="editRoleFrm">
                        <div class="form-group">
                            <label for="role_title">Role Title</label>
                            <input type="text" name="role_title" id="role_title" class="form-control" value="{{ $data->role_title }}" />
                        </div>
                        <div class="form-group">
                            <label for="role_slug">Role Slug</label>
                            <input type="text" name="role_slug" id="role_slug" class="form-control" value="{{ $data->role_slug }}"/>
                        </div>
                        <div class="form-group">
                            <label for="role_level">Role Level</label>
                            <input type="number" name="role_level" id="role_level" class="form-control" value="{{ $data->role_level }}" />
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" />{{ $data->description }}</textarea>
                        </div>
                        <button type="submit" id="submitFrm" name="submitFrm" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- /.row -->
</section>
@stop

@section("scripts")
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/role/edit') }}"></script>
@stop
<script>
var role_id = "<?php echo $data->role_id; ?>";
</script>