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
                        <td>Page Title</td>
                        <td width="300">URL</td>
                        <td width="80">Status</td>
                    @else
                        <td width="250">Page</td>
                    @endif
                    <td width="50">Action</td>
                </tr>
            </thead>
            <tbody>
                @if (count($pages)>0)
                    @foreach($pages as $page)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            @if (Session::get('is_desktop'))
                                <td>{{ $page->post_title }}</td>
                                <td>{{ $page->post_slug }}</td>
                                <td>{{ _get_status_text($page->post_status) }}</td>
                            @else
                                <td>
                                    {{ str_limit($page->post_title, 50) }}<br>
                                    <small>{{ _get_status_text($page->post_status) }}</small>
                                </td>
                            @endif
                            <td>{{ _get_button_access($page->post_id) }}</td>
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