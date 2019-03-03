@php $no=1 @endphp
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
                        @if (Session::get('is_desktop'))
                            <td width="250">Duration</td>
                            <td>Description</td>
                            <td width="80">Status</td>
                        @else
                            <td width="200">Duration</td>
                        @endif
                    <td width="50">Action</td>
                </tr>
            </thead>
            <tbody>
                @if (count($durations)>0)
                    @foreach($durations as $duration)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            @if (Session::get('is_desktop'))
                                <td>{{ $duration->duration_name }}</td>
                                <td>{{ $duration->duration_description }}</td>
                                <td>{{ _get_status_text($duration->duration_status) }}</td>
                            @else
                                <td>
                                    {{ $duration->duration_name }}<br>
                                    <small>{{ _get_status_text($duration->duration_status) }}</small>
                                </td>
                            @endif
                            <td>{{ _get_button_access($duration->duration_id) }}</td>
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