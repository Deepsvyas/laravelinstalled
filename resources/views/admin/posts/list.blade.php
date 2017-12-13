@extends('layouts.admin.main',['request' => $request])
@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info posts_list_wrap">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bar-chart-o fa-fw"></i> Post List </h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-sm btn-default refresh_list">
                            <i class="fa fa-refresh"></i>
                        </a>
                        
                        <a class="btn btn-sm btn-danger" id="posts_delete_rows" href="{{ url('admin/posts/delete') }}">
                            <i class="fa fa-trash-o"></i>
                            Delete
                        </a>
                        
                        <a class="btn btn-sm btn-success " id="openAddNewPostFrm" href="#">Add New</a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div id="posts_list_cont">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>


<!-- Add New Post Model -->
<div class="modal fade" id="add_new_post_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="box box-info">
                <form action="" method="post" name="addNewPostFrm" id="addNewPostFrm">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="page_heading">Add New  </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row control-group">
                                    <div class="form-group col-xs-12 controls">
                                        <label for="">Post Image</label>
                                        <div class='pic_preview'>
                                            <img id="post_image_view" src="" width="100" height="100" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row control-group">
                                    <div class="form-group">
                                        <label for="post_image">&nbsp;</label>
                                        <input type="file" name="post_image" id="post_image" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="post_author">Post Author </label>
                            <input type="text" class="form-control" id="post_author" name="post_author" >
                        </div>
                        <div class="form-group">
                            <label for="post_title">Post Title</label>
                            <input type="text" class="form-control" id="post_title" name="post_title" >
                        </div>
                        <div class="form-group">
                            <label for="post_publish">Post Publish</label>
                            <input type="checkbox" id="post_publish" name="post_publish" value="1">
                        </div>
                        <div id="ckeditor_postdesc">
                            <div class="form-group">
                                <label for="post_desc_h">Post Description </label>
                                <textarea class="form-control" id="post_desc" name="post_desc"></textarea>
                                <input type="hidden" id="post_desc_h" name="post_desc_h">
                                <input type="hidden" id="post_key" name="post_key">
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label for="post_youtube_video_url">{{ trans('labels.post.post_youtube_video_url') }}</label>
                            <input type="text" class="form-control" id="post_youtube_video_url" name="post_youtube_video_url" >
                        </div>-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" id="submitPostFrm" name="submitPostFrm" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div><!-- /.modal -->
<!-- /.Add New Post Model -->


<!-- Ajax Comment list -->
<div class="modal fade" id="comment_list_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Comments List </h4>
            </div>
            <div class="modal-body comments_list_wrap">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /.Ajax Comment list -->

<!-- Comment edit modal -->
<div class="modal fade" id="comment_edit_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ trans('comments.edit_comment') }}</h4>
            </div>
            <div class="modal-body">
                <form name="editCommentFrm" id="editCommentFrm">
                    <div class="form-group">
                        <label for="comment_message">{{ trans('comments.labels.comment_message') }}</label>
                        <textarea class="form-control" id="comment_message" name="comment_message" ></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('labels.buttons.close') }}</button>
                        <button type="submit" id="updateCommentFrm" name="updateCommentFrm" class="btn btn-success">{{ trans('labels.buttons.update') }}</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /.Comment edit modal -->

@stop
@section("styles")
<link rel="stylesheet" type="text/css" href="{{ ViewsHelper::css('toggle/bootstrap-toggle.min') }}"/>
@stop
@section("scripts")
<script>
    var add_new_post = "{{ trans('labels.post.add_new') }}";
    var edit_post = "{{ trans('labels.post.edit_post') }}";
</script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/plugins/jQueryUI/jquery-ui.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/iCheck/icheck.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/toggle/bootstrap-toggle.min') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('admin/custom/posts/list') }}"></script>
<script type="text/javascript" src="{{ ViewsHelper::js('plugins/ckeditor/ckeditor') }}"></script>
<script>
    var new_post = "{{$new_post}}";
</script>
@stop