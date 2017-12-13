<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
             
                <th style="width: 10px"><input type="checkbox" id="product-categories_checkallitem"></th>
                <th>
                    Category Image
                </th> 
                <th data-field="category_title" data-search="true">
                    Category title 
                </th>
                <th data-field="category_desc" data-search="true">
                    Category Description
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
        @foreach($data as $row) <?php //echo '<pre>';print_r($row); ?>
        <tr>
            
            <td>
                <input name="selected[]" class="product-categories_actionsid square-blue" value="<?php echo $row->category_id; ?>" type="checkbox">
            </td>
            <td>
                <img src="<?php echo PostHelper::getCategoryImage($row, "100_100"); ?>" width="100" height="100" />
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

                <a class="btn btn-info btn-xs open_edit_category" data-key="{{ $row->category_id }}" href="#" > Edit </a>

                <div class="height5"></div>
                <input type="checkbox" id="check_status" class="category_active" <?php if ($row->status == 1) echo 'checked="checked"'; ?> data-val="{{ $row->category_id }}"  data-url="{{ url('admin/product-category/update_active') }}" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="Published" data-off="Unpublished">
                
            </td>
        </tr>
        @endforeach
        @endif
    </table>
    {!! $data->render() !!}
</div>