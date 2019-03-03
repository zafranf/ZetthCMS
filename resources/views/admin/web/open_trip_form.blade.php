@php
$include = [];
$exclude = [];
$day = [];
if(isset($open->post_id)){
    foreach ($open->facility as $key => $value) {
        if($value->facility_type=="include")
            $include[] = $value->facility_id;
        if($value->facility_type=="exclude")
            $exclude[] = $value->facility_id;
    }
    foreach ($open->schedule as $key => $value) {
        $day[$value->schedule_day][] = $value;
    }
}
@endphp

@extends('admin.layout')

@section('styles')
{!! _load_select2('css') !!}
{!! _load_fancybox('css') !!}
{!! _load_datetimepicker('css') !!}
<style>
    .pwd-upload-exists {
        display: none;
    }
    .nav-pills {
        border-bottom: 0;
    }
    .nav-pills>li>a {
        border-radius: 0;
        border-bottom: 0;
    }
    .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
        border: 0;
        background-color: #eee;
        color: #8B8B8B;
    }
</style>
@endsection

@section('content')
    <div class="panel-body">
        <form class="form-horizontal" action="{{ url(Session::get('current_url')) }}{{ isset($open->post_id)?'/'.$open->post_id:'' }}" method="post" enctype="multipart/form-data">
            {{ isset($open->post_id)?method_field('PUT'):'' }}
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-2 no-padding">
                    <ul class="nav nav-pills nav-stacked">
                      <li class="active"><a data-toggle="tab" href="#main">Main Info</a></li>
                      <li><a data-toggle="tab" href="#schedule">Schedule</a></li>
                      <li><a data-toggle="tab" href="#facility">Facilities</a></li>
                    </ul>
                </div>
                <div class="col-md-10" style="border-left:1px solid #ccc;">
                    <div class="tab-content no-padding">
                        <div id="main" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="page-header" style="margin-top:10px;">
                                        <h4 class="no-margin">Main Info</h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="post_cover" class="col-md-4 control-label"><abbr title="Best size 1366x768">Cover</abbr></label>
                                        <div class="col-md-8">
                                            <div class="pwd-upload">
                                                <div class="pwd-upload-new thumbnail">
                                                    <img src="{!! _get_image_temp(isset($open->post_id)?"/assets/images/upload/".$open->post_cover:'', [560]) !!}">
                                                </div>
                                                <div class="pwd-upload-exists thumbnail"></div>
                                                <div>
                                                    <a href="{{ url('assets/plugins/filemanager/dialog.php?type=1&field_id=post_cover&relative_url=1') }}" class="btn btn-default pwd-upload-new" id="btn-upload" type="button">Select</a>
                                                    <a href="{{ url('assets/plugins/filemanager/dialog.php?type=1&field_id=post_cover&relative_url=1') }}" class="btn btn-default pwd-upload-exists" id="btn-upload" type="button">Change</a>
                                                    <a id="btn-remove" class="btn btn-default pwd-upload-exists" type="button">Remove</a>
                                                    <input name="post_cover" id="post_cover" type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="post_name" class="col-md-4 control-label">Trip Name</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="post_name" value="{{ isset($open->post_id)?$open->post_title:'' }}" autofocus onfocus="this.value = this.value;" maxlength="100" placeholder="Trip Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="post_description" class="col-md-4 control-label">Description</label>
                                        <div class="col-md-8">
                                            <textarea class="form-control" name="post_description" placeholder="Trip description" rows="5">{{ isset($open->post_id)?$open->post_content:'' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="meeting_point" class="col-md-4 control-label">Meeting Point</label>
                                        <div class="col-md-8">
                                            <select id="meeting_point" name="meeting_point" class="form-control select2">
                                                <option value="">[Choose]</option>
                                                @foreach($points as $point)
                                                    <option value="{{ $point->point_id }}" {{ (isset($open->post_id) && $open->meeting_point[0]->point_id==$point->point_id)?'selected':'' }}>{{ $point->point_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="duration" class="col-md-4 control-label">Duration</label>
                                        <div class="col-md-8">
                                            <select id="duration" name="duration" class="form-control select2">
                                                <option value="">[Choose]</option>
                                                @foreach($durations as $duration)
                                                    <option value="{{ $duration->duration_id }}" {{ (isset($open->post_id) && $open->duration[0]->duration_id==$duration->duration_id)?'selected':'' }}>{{ $duration->duration_name.' ('.$duration->duration_description.')' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="price" class="col-md-4 control-label">Price</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="price[]" value="{{ isset($open->post_id)?$open->price[0]->price_price:0 }}" placeholder="Price/person">
                                            <input type="hidden" name="minimal_person[]" value="1">
                                            <input type="hidden" name="maximal_person[]" value="1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="price" class="col-md-4 control-label">Trip Date</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="post_time" name="post_time" value="{{ date("Y-m-d", strtotime('next Saturday')) }}" placeholder="Trip Date">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-4">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="post_status" {{ (isset($open->post_status) && $open->post_status==0)?'':'checked' }}> Active
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="schedule" class="tab-pane">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="page-header" style="margin-top:10px;">
                                        <h4 class="no-margin">Schedule</h4>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#day1">Day 1</a></li>
                                        @for($t=2;$t<=7;$t++ )
                                            <li><a data-toggle="tab" href="#day{{ $t }}">Day {{ $t }}</a></li>
                                        @endfor
                                    </ul>
                                    <div class="tab-content">
                                        <div id="day1" class="tab-pane active">
                                            <div class="col-md-6" style="margin-top:10px;">
                                                <p>Day 1 schedule. <a id="btn-add-schedule" class="btn btn-default btn-xs pull-right" title="Add Schedule"><i class="fa fa-plus"></i></a></p>
                                                <div id="d_shedule">
                                                    {{-- Form Header --}}
                                                    <div class="col-md-1 no-padding" style="padding-left: 10px;"><b>No.</b></div>
                                                    <div class="col-md-2 no-padding" style="padding-left: 10px;"><b>Time</b></div>
                                                    <div class="col-md-2 no-padding" style="padding-left: 10px; display:none;"><b>Until</b></div>
                                                    <div class="col-md-9 no-padding" style="padding-left: 10px;"><b>Activity</b></div>
                                                    @if(isset($open->post_id))
                                                        @foreach($day[1] as $n => $schedule)
                                                            <div id="schedule1{{ ++$n }}"><div class="col-md-1 no-padding"><input type="text" class="form-control no-radius-right text-center" value="{{ $n }}" readonly></div>
                                                            <div class="col-md-2 no-padding"><input type="text" name="start[]" class="form-control no-radius timepicker" placeholder="Time" value="{{ isset($open->post_id)?$schedule->schedule_start:date('H') }}"></div>
                                                            <div class="col-md-2 no-padding" style="display:none;"><input type="text" name="end[]" class="form-control no-radius timepicker" placeholder="Until" value="{{ isset($open->post_id)?$schedule->schedule_end:date('H', strtotime('+1 hour')) }}"></div>
                                                            <div class="col-md-{{ ($n>1)?8:9 }} no-padding"><input type="text" name="activity[]" class="form-control no-radius-left" placeholder="Activity" value="{{ isset($open->post_id)?$schedule->schedule_activity:'' }}"><input type="hidden" name="day[]" value="1"></div>
                                                            @if($n>1)
                                                            <div class="col-md-1 no-padding"><center><i style="cursor:pointer;" onclick="_remove('#schedule1{{ $n }}')" class="fa fa-minus form-control no-radius-left" title="delete this schedule"></i></center></div>
                                                            @endif
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        {{-- Form Pertama --}}
                                                        <div class="col-md-1 no-padding"><input type="text" class="form-control no-radius-right text-center" value="1" readonly></div>
                                                        <div class="col-md-2 no-padding"><input type="text" name="start[]" class="form-control no-radius timepicker" placeholder="Time" value="{{ date('H') }}"></div>
                                                        <div class="col-md-2 no-padding" style="display:none;"><input type="text" name="end[]" class="form-control no-radius timepicker" placeholder="Until" value="{{ date('H', strtotime('+1 hour')) }}"></div>
                                                        <div class="col-md-9 no-padding"><input type="text" name="activity[]" class="form-control no-radius-left" placeholder="Activity"><input type="hidden" name="day[]" value="1"></div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @for($b=2;$b<=7;$b++)
                                            <div id="day{{ $b }}" class="tab-pane">
                                                <div id="d_show_schedule{{ $b }}" class="col-md-6" style="margin-top:10px;">
                                                    <p>Day {{ $b }} schedule. <a id="btn-add-schedule{{ $b }}" class="btn btn-default btn-xs pull-right" title="Add Schedule"><i class="fa fa-plus"></i></a></p>
                                                    <div id="d_shedule{{ $b }}">
                                                        {{-- Form Header --}}
                                                        <div class="col-md-1 no-padding" style="padding-left: 10px;"><b>No.</b></div>
                                                        <div class="col-md-2 no-padding" style="padding-left: 10px;"><b>Time</b></div>
                                                        <div class="col-md-2 no-padding" style="padding-left: 10px; display:none;"><b>Until</b></div>
                                                        <div class="col-md-9 no-padding" style="padding-left: 10px;"><b>Activity</b></div>
                                                        @if(isset($open->post_id) && isset($day[$b]))
                                                            @foreach($day[$b] as $n => $schedule)
                                                                <div id="schedule{{ $b }}{{ ++$n }}"><div class="col-md-1 no-padding"><input type="text" class="form-control no-radius-right text-center" value="{{ $n }}" readonly></div>
                                                                <div class="col-md-2 no-padding"><input type="text" name="start[]" class="form-control no-radius timepicker" placeholder="Time" value="{{ isset($open->post_id)?$schedule->schedule_start:date('H') }}"></div>
                                                                <div class="col-md-2 no-padding" style="display:none;"><input type="text" name="end[]" class="form-control no-radius timepicker" placeholder="Until" value="{{ isset($open->post_id)?$schedule->schedule_end:date('H', strtotime('+1 hour')) }}"></div>
                                                                <div class="col-md-8 no-padding"><input type="text" name="activity[]" class="form-control no-radius-left" placeholder="Activity" value="{{ isset($open->post_id)?$schedule->schedule_activity:'' }}"><input type="hidden" name="day[]" value="{{ $b }}"></div>
                                                                <div class="col-md-1 no-padding"><center><i style="cursor:pointer;" onclick="_remove('#schedule{{ $b }}{{ $n }}')" class="fa fa-minus form-control no-radius-left" title="delete this schedule"></i></center></div></div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="facility" class="tab-pane">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="page-header" style="margin-top:10px;">
                                                <h4 class="no-margin">Includes</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div id="d_include">
                                            @foreach($facilities as $facility)
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="include[]" id="in-{{ str_slug($facility->facility_name) }}" value="{{ $facility->facility_id }}" class="c_include" {{ in_array($facility->facility_id, $include)?'checked':'' }}  {{ in_array($facility->facility_id, $exclude)?'disabled':'' }}> <small>{{ $facility->facility_name }}</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="page-header">
                                                <h4 class="no-margin">Excludes</h4>
                                            </div>
                                            <div id="d_exclude">
                                            @foreach($facilities as $facility)
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="exclude[]" id="ex-{{ str_slug($facility->facility_name) }}" value="{{ $facility->facility_id }}" class="c_exclude" {{ in_array($facility->facility_id, $exclude)?'checked':'' }} {{ in_array($facility->facility_id, $include)?'disabled':'' }}> <small>{{ $facility->facility_name }}</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top:20px;">
                <div class="col-md-offset-2 col-md-10">
                  {{ _get_button_post() }}
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
{!! _load_select2('js') !!}
{!! _load_fancybox('js') !!}
{!! _load_momentjs('js') !!}
{!! _load_datetimepicker('js') !!}
<script>
var wFB = window.innerWidth - 30;
var hFB = window.innerHeight - 60;
var no_schedule = {{ isset($open->post_id)?count($day[1]):1 }};
@for($s=2;$s<=7;$s++)
    var no_schedule{{ $s }} = {{ (isset($open->post_id) && isset($day[$s]) )?count($day[$s]):0 }};
@endfor
var no_price = {{ isset($open->post_id)?count($open->price):1 }};

$(function(){
    $(".select2").select2({
        placeholder: '[Choose]',
        minimumResultsForSearch: Infinity
    });
    $('.timepicker').datetimepicker({
        format: 'HH:mm'
    });
});

function responsive_filemanager_callback(field_id){
    var url = $('#'+field_id).val().replace(SITE_URL, "");
    var img = '<img src="'+url+'">';
    $('.pwd-upload-new').hide();
    $('.pwd-upload-exists').show();
    $('.pwd-upload-exists.thumbnail').html(img);
}

$(document).ready(function(){
    $('#btn-upload').fancybox({
        type      : 'iframe',
        autoScale : false,
        autoSize : false,
        beforeLoad : function() {
            this.width  = wFB;
            this.height = hFB;
        }
    });
    $('#btn-add-schedule').click(function(){
        no_schedule++;
        html = '<div id="schedule1'+no_schedule+'"><div class="col-md-1 no-padding"><input type="text" class="form-control no-radius-right text-center" value="'+no_schedule+'" readonly></div>'
            +'<div class="col-md-2 no-padding"><input type="text" name="start[]" class="form-control no-radius timepicker" placeholder="Time" value="{{ date('H') }}"></div>'
            +'<div class="col-md-2 no-padding" style="display:none;"><input type="text" name="end[]" class="form-control no-radius timepicker" placeholder="Until" value="{{ date('H', strtotime('+1 hour')) }}"></div>'
            +'<div class="col-md-8 no-padding"><input type="text" name="activity[]" class="form-control no-radius" placeholder="Activity"><input type="hidden" name="day[]" value="1"></div>'
            +'<div class="col-md-1 no-padding"><center><i style="cursor:pointer;" onclick="_remove(\'#schedule1'+no_schedule+'\')" class="fa fa-minus form-control no-radius-left" title="delete this schedule"></i></center></div></div>';
        $('#d_shedule').append(html);
        $('.timepicker').datetimepicker({
            format: 'HH:mm'
        });
    });
    @for($as=2;$as<=7;$as++)
        $('#btn-add-schedule{{ $as }}').click(function(){
            no_schedule{{ $as }}++;
            html = '<div id="schedule{{ $as }}'+no_schedule{{ $as }}+'"><div class="col-md-1 no-padding"><input type="text" class="form-control no-radius-right text-center" value="'+no_schedule{{ $as }}+'" readonly></div>'
                +'<div class="col-md-2 no-padding"><input type="text" name="start[]" class="form-control no-radius timepicker" placeholder="Time" value="{{ date('H') }}"></div>'
                +'<div class="col-md-2 no-padding" style="display:none;"><input type="text" name="end[]" class="form-control no-radius timepicker" placeholder="Until" value="{{ date('H', strtotime('+1 hour')) }}"></div>'
                +'<div class="col-md-8 no-padding"><input type="text" name="activity[]" class="form-control no-radius" placeholder="Activity"><input type="hidden" name="day[]" value="{{ $as }}"></div>'
                +'<div class="col-md-1 no-padding"><center><i style="cursor:pointer;" onclick="_remove(\'#schedule{{ $as }}'+no_schedule{{ $as }}+'\')" class="fa fa-minus form-control no-radius-left" title="delete this schedule"></i></center></div></div>';
            $('#d_shedule{{ $as }}').append(html);
            $('.timepicker').datetimepicker({
                format: 'HH:mm'
            });
        });
    @endfor
    $('#btn-add-price').click(function(){
        no_price++;
        html = '<div id="price'+no_price+'"><div class="col-md-1 no-padding"><input type="text" class="form-control no-radius-right text-center" value="'+no_price+'" readonly></div>'
            +'<div class="col-md-2 no-padding">'
                +'<select name="minimal_person[]" id="minimal_person" class="form-control no-radius">'
                    @for($i=1;$i<=20;$i++)
                        +'<option>{{ $i }}</option>'
                    @endfor
                    +'<option>&gt;</option>'
                +'</select>'
            +'</div>'
            +'<div class="col-md-2 no-padding">'
                +'<select name="maximal_person[]" id="maximal_person" class="form-control no-radius">'
                    @for($i=1;$i<=20;$i++)
                        +'<option>{{ $i }}</option>'
                    @endfor
                +'</select>'
            +'</div>'
            +'<div class="col-md-6 no-padding"><input type="text" name="price[]" class="form-control no-radius-left" placeholder="Price"></div>'
            +'<div class="col-md-1 no-padding"><center><i style="cursor:pointer;" onclick="_remove(\'#price'+no_price+'\')" class="fa fa-minus form-control no-radius-left" title="delete this price"></i></center></div></div>';
        $('#d_price').append(html);
    });
    $('.c_include').click(function(){
        id = $(this).attr('id').replace("in","ex");
        if($(this).is(':checked')){
            $('#'+id).attr('disabled', true);
        }else{
            $('#'+id).attr('disabled', false);
        }
    });
    $('.c_exclude').click(function(){
        id = $(this).attr('id').replace("ex","in");
        if($(this).is(':checked')){
            $('#'+id).attr('disabled', true);
        }else{
            $('#'+id).attr('disabled', false);
        }
    });
});
</script>
@endsection