@php($no=1)
@extends('admin.layout')

@section('styles')
{!! _load_sweetalert('css') !!}
{!! _load_datatables('css') !!}
@endsection

@section('content')
    <div class="panel-body no-padding-right-left">
        <table id="table-data" class="row-border hover">
            <thead>
                <tr>
                    <td width="25">No.</td>
                    @if ($isDesktop)
                        <td width="200">Name</td>
                        <td width="200">Email</td>
                        <td>Message</td>
                        <td width="80">Status</td>
                    @else
                        <td width="300">Message</td>
                    @endif
                    <td width="50">Action</td>
                </tr>
            </thead>
            <tbody>
                @if (count($inboxes)>0)
                    @foreach($inboxes as $inbox)
                        @php(
                            $sts = ['Unread', 'Read']
                        )
                        <tr{!! ($inbox->inbox_read)?'':' style="font-weight:400"' !!}>
                            <td align="center">{{ $no++ }}</td>
                            @if ($isDesktop)
                                <td>{{ $inbox->inbox_name }}</td>
                                <td>{{ $inbox->inbox_email }}</td>
                                <td>{{ str_limit($inbox->inbox_message, 60) }}</td>
                                <td>{{ _get_status_text($inbox->inbox_read, $sts) }}</td>
                            @else
                                <td>
                                    {{ $inbox->inbox_name }}: <br>
                                    <small>{{ str_limit($inbox->inbox_message, 50) }}<br>
                                    {{ _get_status_text($inbox->inbox_read, $sts) }}</small>
                                </td>
                            @endif
                            <td>
                                {{ _get_button_access($inbox->inbox_id, $current_url) }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
{!! _load_sweetalert('js') !!}
{!! _load_datatables('js') !!}
@endsection