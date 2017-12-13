<div class="box box-info ">
    <div class="box-header with-border">
        <h3 class="box-title"> Comments For Post <b>{{ $post->short_title()}}</b></h3>
        <div class="box-tools pull-right">
            <a class="btn btn-sm btn-default refresh_list">
                <i class="fa fa-refresh"></i>
            </a>
            <a class="btn btn-sm btn-danger" id="comment_delete_rows" href="{{ url('admin/posts/deletecomment') }}">
                <i class="fa fa-trash-o"></i>
                Delete
            </a>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table class="table no-margin">
                <thead>
                    <tr>
                        <th style="width: 10px"><input type="checkbox" id="comment_checkallitem"></th>
                        <th>
                            User Name
                        </th>
                        <th data-field="comment_message">
                            Comment
                        </th>

                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                @if($data->isEmpty())
                <tr class="empty_listing">
                    <td colspan="7" class="text-center">
                        <div class="col-lg-offset-3 col-lg-6"> 
                            <div class="bs-callout bs-callout-info"> Empty List!</div>
                        </div>
                    </td>
                </tr>
                @else
                @foreach ($data as $row)
                <tr>

                    <td><input name="selected[]" class="comment_actionsid square-blue" value="{{ $row->comment_key }}" type="checkbox"></td>
                    <td>
                        <b>User Name : </b>@if(isset($row->user->first_name)) {{ $row->user->full_name() }} @endif<br>
                        <b>Email : </b>@if(isset($row->user->email)) {{ $row->user->email or '' }} @endif<br>
                        <b>Date : </b>{{ CommonHelper::timestampToDate($row->created_at) }}
                    </td>
                    <td>
                        <?php echo substr($row->comment_message, 0, 50); ?>
                    </td>

                    <td>
                        <a class="btn btn-info btn-xs open_edit_comment_frm" data-val = "{{ $row->comment_key }}"><i class="fa fa-pencil"></i> Edit </a>
                        <div class="height5"></div>
                        <input type="checkbox" id="check_status" class="active_deactive" <?php if ($row->status == 1) echo 'checked="checked"'; ?> data-val="<?php echo $row->comment_key; ?>" data-url="{{ url('admin/posts/comment/update_active') }}" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="Published" data-off="Unpublished">
                    </td>

                </tr>
                @endforeach
                @endif
            </table>
        </div><!-- /.table-responsive -->
    </div><!-- /.box-body -->
    <div class="box-footer clearfix">
        {!! $data->render() !!}
    </div><!-- /.box-footer -->
</div><!-- /.box -->
