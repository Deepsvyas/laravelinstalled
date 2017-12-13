<div class="table-responsive">
    <table class="table table-striped">
        <tr>
            @if(ViewsHelper::hasAccessTo('delete'))
            <th style="width: 10px"><input type="checkbox" id="config_checkallitem"></th>
            @endif
            <th>
               {{ trans('dbconfig.labels.key') }} 
            </th>
            <th>
               {{ trans('dbconfig.labels.value') }} 
            </th>
            <th>
               {{ trans('labels.created_at') }}  
            </th>
            <th>
               {{ trans('labels.last_updated') }}  
            </th>
            <th>
               {{ trans('dbconfig.labels.action') }} 
            </th>
        </tr>
        @foreach($data as $row)
        <tr>
            @if(ViewsHelper::hasAccessTo('delete'))
            <td>
                <input name="selected[]" class="config_actionsid square-blue" value="<?php echo $row->config_key; ?>" type="checkbox">
            </td>
            @endif
            <td>
                {{ $row->def_key }}
            </td>
            <td>
                {{ $row->def_value }}
            </td>
            <td>
                {{CommonHelper::timestampToDate($row->created_at) }}
            </td>
            <td>
                {{CommonHelper::timestampToDate($row->updated_at)}}
            </td>
            <td>
                @if(ViewsHelper::hasAccessTo('edit'))
                <a class="btn btn-info btn-xs open_edit_config" data-key="{{ $row->config_key }}" href="#" >Edit</a>
                <div class="height5"></div>
                <input type="checkbox" id="check_status" class="config_active" <?php if ($row->status == 1) echo 'checked="checked"'; ?> data-val="<?php echo $row->config_key; ?>" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="Enabled" data-off="Disabled">
                @else
                <input type="checkbox" disabled id="check_status"  class="config_active" <?php if ($row->status) echo 'checked="checked"'; ?> data-val="<?php echo $row->config_key; ?>" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="Enabled" data-off="Disabled">
                @endif
            </td>
        </tr>
        @endforeach
    </table>
    {!! $data->render() !!}
</div>
