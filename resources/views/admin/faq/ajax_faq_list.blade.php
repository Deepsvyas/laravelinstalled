<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
             
                <th style="width: 10px"><input type="checkbox" id="faqs_checkallitem"></th>
                <th data-field="faq_title" data-search="true">
                    FAQ's title 
                </th>
                <th data-field="faq_desc" data-search="true">
                    FAQ's Description
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
            <td colspan="5" class="text-center">
                <div class="col-lg-offset-3 col-lg-6"> 
                    <div class="bs-callout bs-callout-info"> Empty List !</div>
                </div>
            </td>
        </tr>
        @else
        @foreach($data as $row) <?php //echo '<pre>';print_r($row); ?>
        <tr>
            
            <td>
                <input name="selected[]" class="faqs_actionsid square-blue" value="<?php echo $row->faq_id; ?>" type="checkbox">
            </td> 
            <td>
                {{ $row->short_title() }}
            </td>
            <td>
                {!! CommonHelper::htmldata($row->short_desc(100)) !!}
            </td>
            <td>
                {{CommonHelper::timestampToDate($row->updated_at)}}
            </td>
            <td>

                <a class="btn btn-info btn-xs open_edit_faq" data-key="{{ $row->faq_id }}" href="#" > Edit </a>

                <div class="height5"></div>
                <input type="checkbox" id="check_status" class="faq_active" <?php if ($row->status == 1) echo 'checked="checked"'; ?> data-val="{{ $row->faq_id }}"  data-url="{{ url('admin/faqs/update_active') }}" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="Published" data-off="Unpublished">
                
            </td>
        </tr>
        @endforeach
        @endif
    </table>
    {!! $data->render() !!}
</div>