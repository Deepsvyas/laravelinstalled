@extends('layouts.admin.main',['request' => $request])
@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart-o fa-fw"></i> {{ trans('dbconfig.static_config_list') }} </h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-default btn-sm go_back_history">{{ trans('labels.buttons.go_back') }}</button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div id="static_conf_cont">



                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th width="25%">
                                       {{ trans('dbconfig.labels.key') }} 
                                    </th>
                                    <th>
                                       {{ trans('dbconfig.labels.value') }} 
                                    </th>
                                    <th>
                                       {{ trans('dbconfig.labels.action') }} 
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <label for= "website_title">{{ trans('dbconfig.labels.website_title') }}</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="website_title" value="{{ $model->getStaticData("website_title") }}" />
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs edit_config" data-key="website_title" href="#" >{{ trans('labels.buttons.update') }}</a>
                                    </td>
                                </tr>

                                    <tr>
                                        <td>
                                            <label for= "website_logo">{{ trans('dbconfig.labels.website_logo') }}</label>
                                        </td>
                                        <td>
                                            <form id="websiteLogoFrm" name="websiteLogoFrm" method="post">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="row control-group">
                                                            <div class="form-group col-xs-12 controls">
                                                                <div class='pic_preview'>
                                                                    <img id="website_logo_view" src="{{ ViewsHelper::getWebsiteLogo($model->getConfigByDefKey('website_logo')) }}" width="100" height="100" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="row control-group">
                                                            <div class="form-group">
                                                                <input type="file" name="website_logo" id="website_logo" class="form-control" />
                                                                <input type="hidden" name="config_edit_key" id="config_edit_key" value="website_logo" />
                                                                <div id="logo_upload_success" class="bs-callout bs-callout-success displaynone" style="padding: 10px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td></td>
                                    </tr>
                                <tr>
                                    <td>
                                        <label for= "admin_email">{{  trans('dbconfig.labels.admin_email') }}</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="admin_email" value="{{ $model->getStaticData("admin_email") }}" />
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs edit_config" data-key="admin_email" href="#" >{{ trans('labels.buttons.update') }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for= "contact_number">{{  trans('dbconfig.labels.contact_number') }}</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="contact_number" value="{{ $model->getStaticData("contact_number") }}" />
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs edit_config" data-key="contact_number" href="#" >{{ trans('labels.buttons.update') }}</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for= "pagination">{{  trans('dbconfig.labels.pagination') }}</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="pagination" value="{{ $model->getStaticData("pagination") }}" />
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs edit_config" data-key="pagination" href="#" >{{ trans('labels.buttons.update') }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for= "google_plus_link">{{  trans('dbconfig.labels.google_plus_link') }}</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="google_plus_link" value="{{ $model->getStaticData("google_plus_link") }}" />
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs edit_config" data-key="google_plus_link" href="#" >{{ trans('labels.buttons.update') }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for= "facebook_link">{{  trans('dbconfig.labels.facebook_link') }}</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="facebook_link" value="{{ $model->getStaticData("facebook_link") }}" />
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs edit_config" data-key="facebook_link" href="#" >{{ trans('labels.buttons.update') }}</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for= "linked_in_link">{{  trans('dbconfig.labels.linked_in_link') }}</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="linked_in_link" value="{{ $model->getStaticData("linked_in_link") }}" />
                                    </td>
                                    <td>
                                        @if(ViewsHelper::hasAccessTo('edit'))
                                        <a class="btn btn-info btn-xs edit_config" data-key="linked_in_link" href="#" >{{ trans('labels.buttons.update') }}</a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for= "twitter_link">{{  trans('dbconfig.labels.twitter_link') }}</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="twitter_link" value="{{ $model->getStaticData("twitter_link") }}" />
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs edit_config" data-key="twitter_link" href="#" >{{ trans('labels.buttons.update') }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for= "post_image_required">{{  trans('dbconfig.labels.post_img_required') }}</label>
                                    </td>
                                    <td>
                                        <input type="checkbox" id="post_image_status" class="update_config_status" data-key="post_image_required" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="" data-on="Yes" data-off="No" @if($model->getStaticData('post_image_required')) checked="checked" @endif >
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for= "default_user_comments_active">{{  trans('dbconfig.labels.default_user_comments_active') }}</label>
                                    </td>
                                    <td>
                                        <input type="checkbox" id="comment_allowed_status" class="update_config_status"  data-key="default_user_comments_active" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="" data-on="Yes" data-off="No" @if($model->getStaticData('default_user_comments_active')) checked="checked" @endif>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for= "comment_box">{{  trans('dbconfig.labels.comment_box') }}</label>
                                    </td>
                                    <td>
                                        <input type="checkbox" id="comment_box" class="update_config_status"  data-key="comment_box" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="" data-on="Yes" data-off="No" @if($model->getStaticData('comment_box')) checked="checked" @endif>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for= "newsletter_minlength">{{  trans('dbconfig.labels.newsletter_char_minlenght') }}</label>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="newsletter_minlength" value="{{ $model->getStaticData("newsletter_minlength") }}" />
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-xs edit_config" data-key="newsletter_minlength" href="#" >{{ trans('labels.buttons.update') }}</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
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
<script type="text/javascript" src="{{ ViewsHelper::js('admin/plugins/jQueryUI/jquery-ui.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/iCheck/icheck.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/toggle/bootstrap-toggle.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/dbconfig/staticlist') }}"></script>
@stop