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
                        <td width="100">Cover</td>
                        <td>Trip Name</td>
                        <td width="200">Meeting Point</td>
                        <td width="150">Duration</td>
                        <td width="80">Status</td>
                    @else
                        <td width="100%">Trip</td>
                    @endif
                    <td width="50">Action</td>
                </tr>
            </thead>
            <tbody>
                @if(count($privates)>0)
                    @foreach($privates as $private)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            @if (Session::get('is_desktop'))
                                <td><img src="{!! _get_image_temp(isset($private->post_id)?"/assets/images/upload/".$private->post_cover:'', [50]) !!}" class="img-thumbnail" width="50"></td>
                                <td>{{ $private->post_title }}</td>
                                <td>
                                    @foreach($private->meeting_point as $point)
                                        {{ $point->point_name }}
                                    @endforeach
                                </td>
                                <td>@foreach($private->duration as $duration)
                                    {{ $duration->duration_name }}
                                @endforeach</td>
                                <td>{{ _get_status_text($private->post_status) }}</td>
                            @else
                                <td>
                                    {{ $private->post_title }}<br>
                                    <small>
                                        <b>
                                            @foreach($private->meeting_point as $point)
                                                {{ $point->point_name }}
                                            @endforeach
                                        </b><br>
                                        {{ _get_status_text($private->post_status) }}
                                    </small>
                                </td>
                            @endif
                            <td>
                                {{ _get_button_access($private->post_id, Session::get('current_url')) }}
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