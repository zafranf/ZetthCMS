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
                            <td width="250">Point</td>
                            <td>Description</td>
                            <td width="80">Status</td>
                        @else
                            <td width="200">Point</td>
                        @endif
                    <td width="50">Action</td>
                </tr>
            </thead>
            <tbody>
                @if (count($points)>0)
                    @foreach($points as $point)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            @if ($isDesktop)
                                <td>{{ $point->point_name }}</td>
                                <td>{{ $point->point_description }}</td>
                                <td>{{ _get_status_text($point->point_status) }}</td>
                            @else
                                <td>
                                    {{ $point->point_name }}<br>
                                    <small>{{ _get_status_text($point->point_status) }}</small>
                                </td>
                            @endif
                            <td>{{ _get_button_access($point->point_id) }}</td>
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