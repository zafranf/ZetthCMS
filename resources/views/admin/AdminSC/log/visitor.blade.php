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
                    <td width="150">IP</td>
                    <td>Referal</td>
                    <td>Page</td>
                    <td width="100">Time</td>
                    {{-- <td width="150">Browser</td>
                    <td width="150">Device</td> --}}
                    <td width="80">Action</td>
                </tr>
            </thead>
            <tbody>
                @if (count($visitors)>0)
                    @foreach($visitors as $visitor)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            <td>{{ $visitor->visitor_ip }}</td>
                            <td>{{ $visitor->visitor_referral }}</td>
                            <td>{{ $visitor->visitor_page }}</td>
                            <td>{{ $visitor->created_at }}</td>
                            {{-- <td>{{ Agent::browser($visitor->visitor_agent) }}</td>
                            <td>{{ $visitor->visitor_device }}</td>--}}
                            <td>
                                {{ _get_button_access($visitor->visitor_id, $current_url) }}
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