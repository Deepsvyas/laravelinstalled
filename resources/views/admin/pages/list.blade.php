@extends('layouts.admin.main',['request' => $request])
@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info pages_list_wrap">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart-o fa-fw"></i>  Page List </h3>
                    <div class="box-tools pull-right">
<!--                        <a class="btn btn-sm btn-default refresh_list"><i class="fa fa-refresh"></i></a>

                        <a class="btn btn-sm btn-danger" id="pages_delete_rows" href="{{ url('admin/pages/delete') }}">
                            <i class="fa fa-trash-o"></i>
                            Delete 
                        </a>
                        <a class="btn btn-sm btn-success " id="openAddNewPageFrm" href="#"> Add New</a>-->
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div id="pages_list_cont">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>

<div class="modal fade" id="page_content_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="add_new_page_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" name="addNewPageFrm" id="addNewPageFrm">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="page_headline"> Add New Page </h4>
                </div>
                <div class="modal-body">
<!--                    <div class="form-group">
                        <label for="page_slug"> Page Slug </label>
                        <input type="text" class="form-control" id="page_slug" name="page_slug">
                    </div>
                    <div class="form-group">
                        <label for="page_title"> Page Title </label>
                        <input type="text" class="form-control" id="page_title" name="page_title" >
                    </div>-->
                    <div class="form-group">
                        <label for="page_heading">Page Heading </label>
                        <input type="text" class="form-control" id="page_heading" name="page_heading" >
                    </div>
                    <div id="ckeditor_pagecontent">
                        <div class="form-group">
                            <label for="page_content">Page Content </label>
                            <textarea class="form-control" id="page_content" name="page_content"></textarea>
                        </div>
                    </div>
<!--                    <div class="form-group">
                        <label for="page_meta_keywords">Page Meta Keywords </label>
                        <input type="text" class="form-control" id="page_meta_keywords" name="page_meta_keywords" >
                    </div>
                    <div class="form-group">
                        <label for="page_meta_description">Page Meta Description</label>
                        <input type="text" class="form-control" id="page_meta_description" name="page_meta_description" >
                    </div>-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"> Close </button>
                    <button type="submit" id="submitPageFrm" name="submitPageFrm" class="btn btn-success"> Save </button>
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
<script>
    var add_new_page = "Add New Page";
    var edit_page = "Edit Page";
</script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/iCheck/icheck.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/toggle/bootstrap-toggle.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/pages/list') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/ckeditor/ckeditor') }}"></script>
@stop