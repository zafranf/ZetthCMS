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
                    <td width="100">Logo</td>
                    <td>Pemilik</td>
                    <td>Nama Bank</td>
                    <td>No. Rekening</td>
                    <td>Cabang</td>
                    <td width="80">Status</td>
                    <td width="80">Aksi</td>
                </tr>
            </thead>
            <tbody>
                @if(count($banks)>0)
                    @foreach($banks as $bank)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            <td><img src="{{ _get_image_temp($bank->bank_logo, [50,50]) }}" width="50"></td>
                            <td>{{ $bank->bank_owner }}</td>
                            <td>{{ $bank->bank_name }}</td>
                            <td>{{ $bank->bank_number }}</td>
                            <td>{{ $bank->bank_branch }}</td>
                            <td>{{ _get_status_text($bank->bank_status) }}</td>
                            <td>
                                {{ _get_button_access($bank->bank_id, Session::get('current_url')) }}
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