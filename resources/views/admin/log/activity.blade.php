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
                    <td>Route</td>
                    <td width="100">Method</td>
                    <td width="100">IP</td>
                    <td width="150">User</td>
                    <td width="100">Time</td>
                    <td width="80">Action</td>
                </tr>
            </thead>
            <tbody>
                @if (count($activities)>0)
                    @foreach($activities as $activity)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            <td>{{ $activity->activity_route }}</td>
                            <td>{{ $activity->activity_action }}</td>
                            <td>{{ $activity->activity_ip }}</td>
                            <td>{{ $activity->user->user_fullname or 'Visitor' }}</td>
                            <td>{{ $activity->created_at }}</td>
                            <td>
                                {{ _get_button_access($activity->activity_id, Session::get('current_url')) }}
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