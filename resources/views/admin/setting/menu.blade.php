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
                        <td>Menu Name</td>
                        <td>URL</td>
                        <td width="100">Target</td>
                        {{-- <td width="80">Order</td> --}}
                        <td width="80">Status</td>
                    @else
                        <td width="200">Menu</td>
                    @endif
                    <td width="50">Action</td>
                </tr>
            </thead>
            <tbody>
                @if (count($menus)>0)
                    @foreach($menus as $menu)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            @if (Session::get('is_desktop'))
                                <td>{{ $menu->menu_name }}</td>
                                <td>{{ $menu->menu_url }}</td>
                                <td>{{ $menu->menu_target }}</td>
                                {{-- <td>{{ $menu->menu_order }}</td> --}}
                                <td>{{ _get_status_text($menu->menu_status) }}</td>
                            @else
                                <td>
                                    {{ $menu->menu_name }}<br>
                                    <small>{{ _get_status_text($menu->menu_status) }}</small>
                                </td>
                            @endif
                            <td>{{ _get_button_access($menu->menu_id) }}</td>
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