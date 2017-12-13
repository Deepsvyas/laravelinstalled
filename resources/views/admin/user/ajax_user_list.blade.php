<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 10px">
                    <input type="checkbox" id="user_checkallitem">
                </th>
                <th>
                    User Image
                </th>
                <th data-field="first_name" data-search="true">
                    First Name
                </th>
                <th data-field="last_name" data-search="true">
                    Last Name
                </th>
                <th data-field="email" data-search="true">
                    Email
                </th>
                <th>
                    Mobile Number
                </th>
                <th data-field="created_at">
                    Member Since
                </th>
                <th data-field="last_login_date">
                    Last Login
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
                    <div class="bs-callout bs-callout-info"> {{ trans('messages.empty_list') }}!</div>
                </div>
            </td>
        </tr>
        @else
        @foreach($data as $row)
       
        <tr>
            <td>
                @if(ViewsHelper::hasAccessTo('users_delete') && Auth::user()->user_id != $row->user_id) 
                <input name="selected[]" class="user_actionsid square-blue" value="<?php echo $row->user_id; ?>" type="checkbox">
                @endif
            </td>
            <td>
                <img src="{{ UserHelper::getAvatar($row, '50_50') }}" height="50px" width="50px"/>
            </td>
            <td>
                {{ $row->first_name }}
            </td>
            <td>
                {{ $row->last_name }}
            </td>
            <td>
                {{ $row->email }}
            </td>
            <td>
                {{ $row->phone_number }}
            </td>
            <td>
                {{ CommonHelper::timestampToDate($row->created_at) }}
            </td>
            <td>
                @if($row->last_login_date > 0)
                {{CommonHelper::timestampToDate($row->last_login_date)}}
                @else
                ---
                @endif
            </td>
            <td>
                @if(ViewsHelper::hasAccessTo('user_edit'))
                <a class="btn btn-info btn-xs" href="{{ url('admin/users/edit/'.$row->user_id) }}">Edit</a>               
                @endif
                @if(ViewsHelper::hasAccessTo('user_edit') && Auth::user()->user_id != $row->user_id) 
                <input type="checkbox" id="check_status" class="user_active" <?php if (!$row->blocked) echo 'checked="checked"'; ?> data-val="{{ $row->user_id }}" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="Enabled" data-off="Disabled">
                @else
                <input type="checkbox" disabled id="check_status"  class="user_active" <?php if (!$row->blocked) echo 'checked="checked"'; ?> data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="mini" data-on="Enabled" data-off="Disabled">
                @endif
            </td>
        </tr>
        @endforeach
        @endif
    </table>
    {!! $data->render() !!}
</div>
