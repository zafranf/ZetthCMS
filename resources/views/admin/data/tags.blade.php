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
                        <td width="250">Tag</td>
                        <td>Description</td>
                        <td width="80">Status</td>
                    @else
                        <td>Tag</td>
                    @endif
                    <td width="50">Action</td>
                </tr>
            </thead>
            <tbody>
                @if (count($tags)>0)
                    @foreach($tags as $tag)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            @if ($isDesktop)
                                <td>{{ $tag->term_name }}</td>
                                <td>{{ $tag->term_description }}</td>
                                <td>{{ _get_status_text($tag->term_status) }}</td>
                            @else
                                <td>
                                    {{ $tag->term_name }}<br>
                                    <small>{{ _get_status_text($tag->term_status) }}</small>
                                </td>
                            @endif
                            <td>{{ _get_button_access($tag->term_id) }}</td>
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