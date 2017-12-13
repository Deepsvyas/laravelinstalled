@extends('layouts.admin.main',['request' => $request])
@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info banners_list_wrap">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart-o fa-fw"></i> Banner List </h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-sm btn-default refresh_list">
                            <i class="fa fa-refresh"></i>
                        </a>
                        
                        <a class="btn btn-sm btn-danger" id="banners_delete_rows" href="{{ url('admin/banners/delete') }}">
                            <i class="fa fa-trash-o"></i>
                            Delete
                        </a>
                        
                        <a class="btn btn-sm btn-success " id="openAddNewbannerFrm" href="#">Add New</a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div id="banners_list_cont">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>


<!-- Add New banner Model -->
<div class="modal fade" id="add_new_banner_modal">
    <div class="modal-dialog modal-lg modal-ms modal-xs">
        <div class="modal-content">
            <div class="box box-info">
                <form action="" method="banner" name="addNewbannerFrm" id="addNewbannerFrm">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="page_heading">Add New  </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row control-group">
                                    <div class="form-group col-xs-12 controls">
                                        <label for="">Banner Image</label>
                                        <div class='pic_preview'>
                                            <img id="banner_image_view" src="" width="100" height="100" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row control-group">
                                    <div class="form-group">
                                        <label for="banner_image">&nbsp;</label>
                                        <input type="file" name="banner_image" id="banner_image" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="banner_title">Banner Title</label>
                            <input type="text" class="form-control" id="banner_title" name="banner_title" >
                        </div>
                        <div class="form-group">
                            <label for="banner_publish">Banner Publish</label>
                            <input type="checkbox" id="banner_publish" name="banner_publish" value="1">
                        </div>
                        <div id="ckeditor_bannerdesc">
                            <div class="form-group">
                                <label for="banner_desc_h">Banner Description </label>
                                <textarea class="form-control" id="banner_desc" name="banner_desc"></textarea>
                                <input type="hidden" id="banner_desc_h" name="banner_desc_h">
                                <input type="hidden" id="banner_id" name="banner_id">
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label for="banner_youtube_video_url">{{ trans('labels.banner.banner_youtube_video_url') }}</label>
                            <input type="text" class="form-control" id="banner_youtube_video_url" name="banner_youtube_video_url" >
                        </div>-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" id="submitbannerFrm" name="submitbannerFrm" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div><!-- /.modal -->
<!-- /.Add New banner Model -->

@stop
@section("styles")
<link rel="stylesheet" type="text/css" href="{{ ViewsHelper::css('toggle/bootstrap-toggle.min') }}"/>
@stop
@section("scripts")
<script>
    var add_new_banner = "{{ trans('labels.banner.add_new') }}";
    var edit_banner = "{{ trans('labels.banner.edit_banner') }}";
</script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/plugins/jQueryUI/jquery-ui.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/iCheck/icheck.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/toggle/bootstrap-toggle.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/banners/list') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/ckeditor/ckeditor') }}"></script>
<script>
    var new_banner = "{{$new_banner}}";
</script>
@stop