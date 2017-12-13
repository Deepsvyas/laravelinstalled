@extends('layouts.admin.main',['request' => $request])

@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Profile</h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-default btn-sm go_back_history"><i class="fa fa-arrow-left"></i> Go Back </a>
                    </div>
                    <div class="height5"></div>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <form role="form" name="editProfileFrm" id="editProfileFrm">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="row control-group">
                                    <div class="form-group col-xs-12 controls">
                                        <label for=""> Profile Image </label>
                                        <div class='pic_preview'>
                                            <img id="profile-pic" src="{{ UserHelper::getAvatar($data) }}" width="100" height="100" />
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


                        <div class="row">
                            <div class="col-md-6">
                                <div class="row control-group">
                                    <div class="form-group col-xs-12 controls">
                                        <label for="first_name">First Name </label>
                                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $data->first_name }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row control-group">
                                    <div class="form-group col-xs-12 controls">
                                        <label for="last_name"> Last Name </label>
                                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $data->last_name }}" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row control-group">
                                    <div class="form-group col-xs-12 controls">
                                        <label for="email"> Email </label>
                                        <input type="text" name="email" id="email" class="form-control" value="{{ $data->email }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row control-group">
                                    <div class="form-group col-xs-12 controls">
                                        <label for="phone_number">Phone Number </label>
                                        <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $data->phone_number }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="callout callout-info">
                           Note : Not necessary to change your password.
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row control-group">
                                    <div class="form-group col-xs-12 controls">
                                        <label for="password">Password </label>
                                        <input type="password" name="password" id="password" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row control-group">
                                    <label for="conf_password">Confirm Password </label>
                                    <input type="password" name="conf_password" id="conf_password" class="form-control" />
                                </div>
                            </div>
                        </div>

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
<script>
    var user_key = "{{ $data->user_id }}";
</script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/user/edit_profile') }}"></script>
@stop