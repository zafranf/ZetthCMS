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
                            <td width="250">Category</td>
                            <td>Description</td>
                            <td width="200">Parent</td>
                            <td width="80">Status</td>
                        @else
                            <td width="200">Category</td>
                        @endif
                    <td width="50">Action</td>
                </tr>
            </thead>
            <tbody>
                @if (count($categories)>0)
                    @foreach($categories as $category)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            @if ($isDesktop)
                                <td>{{ $category->term_name }}</td>
                                <td>{{ $category->term_description }}</td>
                                <td>
                                    @if ($category->term_parent)
                                        @foreach($categories as $cat)
                                            @if ($category->term_parent==$cat->term_id)
                                                {{ $cat->term_name }}
                                            @endif
                                        @endforeach
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>{{ _get_status_text($category->term_status) }}</td>
                            @else
                                <td>
                                    {{ $category->term_name }}<br>
                                    <small>{{ _get_status_text($category->term_status) }}</small>
                                </td>
                            @endif
                            <td>{{ _get_button_access($category->term_id) }}</td>
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