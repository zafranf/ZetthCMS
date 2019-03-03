@php($no=1)
@extends('admin.layout')

@section('styles')
{!! _load_sweetalert('css') !!}
<style>
    .pwd-share-button {
        position: relative;
        height: 18px;
        margin-top: -2px;
        padding: 1px 8px 1px 6px;
        /*color: #fff;*/
        cursor: pointer;
        /*background-color: #1b95e0;*/
        border: 1px solid coral;
        border-radius: 3px;
        box-sizing: border-box;
        font-size: 12px;
        line-height: 1.2;
    }
    .pwd-share-button:hover, .pwd-share-button:active, .pwd-share-button:focus {
        text-decoration: none;
    }
</style>
@endsection

@section('content')
    <div class="panel-body">
        From: {{ $inbox->inbox_name }} ({{ $inbox->inbox_email }}) <br>
        Phone: {{ $inbox->inbox_phone!=""?$inbox->inbox_phone:'-' }} <br>
        Date: {{ _generate_date($inbox->created_at, false, 'id') }} <br>
        <br>
        {{ $inbox->inbox_message }}
        <br>
        <br>
        <!-- <a id="btn-delete" class="pwd-share-button" onclick="_delete('{{ $inbox->inbox_id }}', '{{ Session::get('current_url') }}');"><i class="fa fa-envelope"></i> Mark as Unread</a> --> 
        <a id="btn-delete" class="pwd-share-button" onclick="_delete('{{ $inbox->inbox_id }}', '{{ Session::get('current_url') }}');"><i class="fa fa-trash-o"></i> Delete</a>
        <a id="btn-back" class="pwd-share-button" href="{{ url(Session::get('current_url')) }}"><i class="fa fa-caret-left"></i> Back</a> 
    </div>
@endsection

@section('scripts')
{!! _load_sweetalert('js') !!}
@endsection