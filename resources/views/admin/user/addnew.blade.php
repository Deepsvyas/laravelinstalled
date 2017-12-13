@extends('layouts.admin.main',['request' => $request])
@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart-o fa-fw"></i> Add New</h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-sm btn-default go_back_history">
                            <i class="fa fa-arrow-left"></i> Go Back
                        </a>
                        @if(ViewsHelper::hasAccessTo('users_list')) 
                        <a class="btn btn-success btn-sm" href="{{ url('admin/users') }}"> Users List</a>
                        @endif
                    </div>
                    <div class="height5"></div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form role="form" name="addNewFrm" id="addNewFrm">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row control-group">
                                        <div class="form-group col-xs-12 controls">
                                            <label for="">User Image</label>
                                            <div class='pic_preview'>
                                                <img id="profile-pic"  width="100" height="100" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row control-group">
                                        <div class="form-group">
                                            <label for="user_image">&nbsp;</label>
                                            <input type="file" name="user_image" id="photo_id" title="Upload your profile image"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" />
                        </div>
                        <!--<div class="form-group">
                            <label for="user_name">{{ trans('labels.users.user_name') }}</label>
                            <input type="text" name="user_name" id="user_name" class="form-control" />
                        </div>-->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="conf_password">Confirm Password</label>
                            <input type="password" name="conf_password" id="conf_password" class="form-control" />
                        </div>
                        <!--
                                                <div class="row">
                                                    <div class="col-lg-3 form-group">
                                                        <label for="role_id">role</label>
                                                        {!! \Form::select('role_id', $roles,null,['class' => 'form-control', 'id'=>'role_id']) !!}
                                                    </div>
                                                </div>
                        -->
                        <button type="submit" id="submitFrm" name="submitFrm" class="btn btn-success"> Submit </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>
@stop

@section("scripts")
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/user/addnew') }}"></script>
@stop