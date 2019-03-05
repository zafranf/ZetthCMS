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
                        <td width="200">Group Name</td>
                        <td>Description</td>
                        <td width="80">Status</td>
                    @else 
                        <td>Group</td>
                    @endif
                    <td width="80">Action</td>
                </tr>
            </thead>
            <tbody>
                @if (count($groups)>0)
                    @foreach($groups as $group)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            @if ($isDesktop)
                                <td>{{ $group->group_name }}</td>
                                    <td>{{ $group->group_description }}</td>
                                <td>{{ _get_status_text($group->group_status) }}</td>
                            @else
                                <td>
                                    {{ $group->group_name }}<br>
                                    <small>{{ _get_status_text($group->group_status) }}</small>
                                </td>
                            @endif
                            <td>{{ _get_button_access($group->group_id) }}</td>
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