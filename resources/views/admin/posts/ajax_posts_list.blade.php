<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
             
                <th style="width: 10px"><input type="checkbox" id="posts_checkallitem"></th>
                <th>
                    Post Image
                </th>
                <th data-field="post_author" data-search="true">
                    Post Author 
                </th>
                <th data-field="post_title" data-search="true">
                    Post title 
                </th>
                <th data-field="post_desc" data-search="true">
                    Post Description
                </th>
                <th data-field="updated_at">
                    Last Updated
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
                    <div class="bs-callout bs-callout-info"> Empty List !</div>
                </div>
            </td>
        </tr>
        @else
        @foreach($data as $row)
        <tr>
            
            <td>
                <input name="selected[]" class="posts_actionsid square-blue" value="<?php echo $row->post_key; ?>" type="checkbox">
            </td>
            <td>
                <img src="<?php echo PostHelper::getPostimage($row, "100_100"); ?>" width="100" height="100" />
            </td>
            <td>
                {{ $row->post_author }}
            </td>
            <td>
                <a href="{{ $row->seoUrl() }}">{{ $row->short_title() }}</a>
            </td>
            <td>
                {!! CommonHelper::htmldata($row->short_desc(100)) !!}
            </td>
            <td>
                {{CommonHelper::timestampToDate($row->updated_at)}}
            </td>
            <td>

                <a class="btn btn-info btn-xs open_edit_post" data-key="{{ $row->post_key }}" href="#" > Edit </a>

                <div class="height5"></div>
                <input type="checkbox" id="check_status" class="post_active" <?php if ($row->status == 1) echo 'checked="checked"'; ?> data-val="{{ $row->post_key }}"  data-url="{{ url('admin/posts/update_active') }}" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="Published" data-off="Unpublished">

                <div class="height5"></div>
                <a href="#" data-val="{{ $row->post_key }}" class="btn btn-warning btn-xs open_comment_list_modal">
                    View Comments
                    <span class="badge">
                        {{ $row->comments_count()}}
                    </span>
                </a>
            </td>
        </tr>
        @endforeach
        @endif
    </table>
    {!! $data->render() !!}
</div>