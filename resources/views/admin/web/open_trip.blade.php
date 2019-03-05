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
                    @if ($isDesktop)
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
                @if(count($opens)>0)
                    @foreach($opens as $open)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            @if ($isDesktop)
                                <td><img src="{!! _get_image_temp(isset($open->post_id)?"/assets/images/upload/".$open->post_cover:'', [50]) !!}" class="img-thumbnail" width="50"></td>
                                <td>{{ $open->post_title }}</td>
                                <td>
                                    @foreach($open->meeting_point as $point)
                                        {{ $point->point_name }}
                                    @endforeach
                                </td>
                                <td>@foreach($open->duration as $duration)
                                    {{ $duration->duration_name }}
                                @endforeach</td>
                                <td>{{ _get_status_text($open->post_status) }}</td>
                            @else
                                <td>
                                    {{ $open->post_title }}<br>
                                    <small>
                                        <b>
                                            @foreach($open->meeting_point as $point)
                                                {{ $point->point_name }}
                                            @endforeach
                                        </b><br>
                                        {{ _get_status_text($open->post_status) }}
                                    </small>
                                </td>
                            @endif
                            <td>
                                {{ _get_button_access($open->post_id, Session::get('current_url')) }}
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