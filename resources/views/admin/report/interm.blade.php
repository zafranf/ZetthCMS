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
                    @if (Session::get('is_desktop'))
                        <td width="200">Host</td>
                        <td>Text</td>
                        <td width="80">Count</td>
                    @else
                        <td width="250">Term</td>
                    @endif
                    <td width="50">Action</td>
                </tr>
            </thead>
            <tbody>
                @if (count($interms)>0)
                    @foreach($interms as $interm)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            @if (Session::get('is_desktop'))
                                <td>{{ $interm->interm_host }}</td>
                                <td>{{ $interm->interm_text }}</td>
                                <td>{{ $interm->interm_count }}</td>
                            @else
                                <td>
                                    {{ $interm->interm_host }}<br>
                                    <small>{{ $interm->interm_text }} ({{ $interm->interm_count }})</small>
                                </td>
                            @endif
                            <td>
                                {{ _get_button_access($interm->interm_id, Session::get('current_url')) }}
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