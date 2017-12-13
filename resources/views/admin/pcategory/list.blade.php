@extends('layouts.admin.main',['request' => $request])
@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info product-categories_list_wrap">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart-o fa-fw"></i> Category List </h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-sm btn-default refresh_list">
                            <i class="fa fa-refresh"></i>
                        </a>
                        
                        <a class="btn btn-sm btn-danger" id="product-categories_delete_rows" href="{{ url('admin/product-category/delete') }}">
                            <i class="fa fa-trash-o"></i>
                            Delete
                        </a>
                        
                        <a class="btn btn-sm btn-success " id="openAddNewcategoryFrm" href="#">Add New</a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div id="product-categories_list_cont">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>


<!-- Add New category Model -->
<div class="modal fade" id="add_new_category_modal">
    <div class="modal-dialog modal-lg modal-ms modal-xs">
        <div class="modal-content">
            <div class="box box-info">
                <form action="" method="category" name="addNewcategoryFrm" id="addNewcategoryFrm">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="page_heading">Add New  </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row control-group">
                                    <div class="form-group col-xs-12 controls">
                                        <label for="">Category Image</label>
                                        <div class='pic_preview'>
                                            <img id="category_image_view" src="" width="100" height="100" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row control-group">
                                    <div class="form-group">
                                        <label for="category_image">&nbsp;</label>
                                        <input type="file" name="category_image" id="category_image" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_title">Category Title</label>
                            <input type="text" class="form-control" id="category_title" name="category_title" >
                        </div>
                        <div class="form-group">
                            <label for="category_publish">Category Publish</label>
                            <input type="checkbox" id="category_publish" name="category_publish" value="1">
                        </div>
                        <div id="ckeditor_categorydesc">
                            <div class="form-group">
                                <label for="category_desc_h">Category Description </label>
                                <textarea class="form-control" id="category_desc" name="category_desc"></textarea>
                                <input type="hidden" id="category_desc_h" name="category_desc_h">
                                <input type="hidden" id="category_id" name="category_id">
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label for="category_youtube_video_url">{{ trans('labels.category.category_youtube_video_url') }}</label>
                            <input type="text" class="form-control" id="category_youtube_video_url" name="category_youtube_video_url" >
                        </div>-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" id="submitcategoryFrm" name="submitcategoryFrm" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div><!-- /.modal -->
<!-- /.Add New category Model -->

@stop
@section("styles")
<link rel="stylesheet" type="text/css" href="{{ ViewsHelper::css('toggle/bootstrap-toggle.min') }}"/>
@stop
@section("scripts")
<script>
    var add_new_category = "{{ trans('labels.category.add_new') }}";
    var edit_category = "{{ trans('labels.category.edit_category') }}";
</script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/plugins/jQueryUI/jquery-ui.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/iCheck/icheck.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/toggle/bootstrap-toggle.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/pcategories/list') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/ckeditor/ckeditor') }}"></script>
<script>
    var new_category = "{{$new_category}}";
</script>
@stop