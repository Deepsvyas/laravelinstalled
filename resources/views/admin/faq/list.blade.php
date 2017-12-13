@extends('layouts.admin.main',['request' => $request])
@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info faqs_list_wrap">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart-o fa-fw"></i> FAQ's List </h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-sm btn-default refresh_list">
                            <i class="fa fa-refresh"></i>
                        </a>
                        
                        <a class="btn btn-sm btn-danger" id="faqs_delete_rows" href="{{ url('admin/faqs/delete') }}">
                            <i class="fa fa-trash-o"></i>
                            Delete
                        </a>
                        
                        <a class="btn btn-sm btn-success " id="openAddNewfaqFrm" href="#">Add New</a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div id="faqs_list_cont">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>


<!-- Add New faq Model -->
<div class="modal fade" id="add_new_faq_modal">
    <div class="modal-dialog modal-lg modal-ms modal-xs">
        <div class="modal-content">
            <div class="box box-info">
                <form action="" method="faq" name="addNewfaqFrm" id="addNewfaqFrm">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="page_heading">Add New  </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="faq_title">FAQ's Title</label>
                            <input type="text" class="form-control" id="faq_title" name="faq_title" >
                        </div>
                        <div class="form-group">
                            <label for="faq_publish">FAQ's Publish</label>
                            <input type="checkbox" id="faq_publish" name="faq_publish" value="1">
                        </div>
                        <div id="ckeditor_faqdesc">
                            <div class="form-group">
                                <label for="faq_desc_h">FAQ's Description </label>
                                <textarea class="form-control" id="faq_desc" name="faq_desc"></textarea>
                                <input type="hidden" id="faq_desc_h" name="faq_desc_h">
                                <input type="hidden" id="faq_id" name="faq_id">
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label for="faq_youtube_video_url">{{ trans('labels.faq.faq_youtube_video_url') }}</label>
                            <input type="text" class="form-control" id="faq_youtube_video_url" name="faq_youtube_video_url" >
                        </div>-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" id="submitfaqFrm" name="submitfaqFrm" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div><!-- /.modal -->
<!-- /.Add New faq Model -->

@stop
@section("styles")
<link rel="stylesheet" type="text/css" href="{{ ViewsHelper::css('toggle/bootstrap-toggle.min') }}"/>
@stop
@section("scripts")
<script>
    var add_new_faq = "{{ trans('labels.faq.add_new') }}";
    var edit_faq = "{{ trans('labels.faq.edit_faq') }}";
</script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/plugins/jQueryUI/jquery-ui.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/iCheck/icheck.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/toggle/bootstrap-toggle.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/faqs/list') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/ckeditor/ckeditor') }}"></script>
<script>
    var new_faq = "{{$new_faq}}";
</script>
@stop