<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 10px"><input type="checkbox" id="pages_checkallitem"></th>
<!--                <th data-field="page_title" data-search="true">
                    Page Title 
                </th>-->
                <th data-field="page_heading" data-search="true">
                    Page Heading  
                </th>
<!--                <th data-field="page_slug" data-search="true">
                    Page Slug 
                </th>
                <th>
                    Page Meta Keywords
                </th>
                <th>
                    Page Meta Description 
                </th>-->
                <th>
                    Page Content 
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
            <td colspan="4" class="text-center">
                <div class="col-lg-offset-3 col-lg-6"> 
                    <div class="bs-callout bs-callout-info"> Empty List !</div>
                </div>
            </td>
        </tr>
        @else
        @foreach($data as $row)
        <tr>
            <td>
                <input name="selected[]" class="pages_actionsid square-blue" value="{{ $row->page_key }}" type="checkbox">
            </td>
<!--            <td>
                {{ $row->page_title }}
            </td>-->
            <td>
                {{ $row->page_heading }}
            </td>
<!--            <td>
                {{ $row->page_slug }}
            </td>-->
<!--            <td>
                {{ $row->page_meta_keywords }}
            </td>
            <td>
                {{ $row->page_meta_description }}
            </td>-->
            <td>
                <a href="#" data-key="{{ $row->page_id }}" class="open_page_content">
                    Page content
                </a>
                <div id="page_content_{{ $row->page_id }}" style="display: none;">
                    {!! CommonHelper::htmlData($row->page_content) !!}
                </div>
            </td>
            <td>
                {{CommonHelper::timestampToDate($row->updated_at)}}
            </td>
            <td>
                <a class="btn btn-info btn-xs open_edit_page" data-key="{{ $row->page_id }}" href="#" > Edit </a>
                <div class="height5"></div>
<!--                <input type="checkbox" id="check_status" class="page_active" <?php if ($row->status == 1) echo 'checked="checked"'; ?> data-val="{{ $row->page_id }}" data-url="{{ url('admin/pages/update_active') }}" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="Enabled" data-off="Disabled">-->
            </td>
        </tr>
        @endforeach
        @endif
    </table>
    {!! $data->render() !!}
</div>
