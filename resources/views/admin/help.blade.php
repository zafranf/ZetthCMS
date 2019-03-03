@extends('admin.layout')

@section('styles')
<style>
    #help-content {
        font-size: 16px;
    }
    #content-div {
        display:none;
    }
    #myScrollspy .nav>li.active>a, #myScrollspy .nav>li.active>a:focus, #myScrollspy .nav>li.active>a:hover {
        border-left: 3px solid coral;
    }
    #myScrollspy .nav>li>a {
        padding: 5px;
        border-left: 3px solid transparent;
    }
    #myScrollspy .nav .nav {
        display: none;
    }
    #myScrollspy .nav>li>a:focus, #myScrollspy .nav>li>a:hover {
        border-left: 3px solid coral;
    }
    .section {
        min-height: 100px;
    }
    .affix {
        top: 80px;
        min-width: 292.5px;
    }
</style>
@endsection

@section('content2')
  <div class="row no-margin" id="help-section">
    <div class="col-sm-10 col-sm-offset-2">
        <div class="col-sm-3 no-padding">
            <nav id="myScrollspy" class="">
                <ul class="nav">
                    @php
                        $par = [
                            'id'        => 'menu_id',
                            'parent'    => 'menu_parent',
                            'name'      => 'menu_name', 
                            'print'     => 'menu_list'
                        ]
                    @endphp
                    {{ _build_tree(Session::get('menu'), $par) }}
                </ul>
            </nav>
        </div>
        <div class="col-sm-9" id="help-content">
            <div class="col-sm-10">
                <p>Di sini anda akan dijelaskan bagaimana cara mengoperasikan website ini melalui panel admin. Penjelasan pada setiap halaman akan dijabarkan secara mendetail untuk setiap fitur dan bagian-bagian yang ada di halaman tersebut sehingga kami harap anda dapat mengoperasikan website ini secara mandiri.</p>
                @php
                    $par = [
                        'id'        => 'menu_id',
                        'parent'    => 'menu_parent',
                        'name'      => 'menu_name', 
                        'print'     => 'help_list'
                    ]
                @endphp
                {{ _build_tree(Session::get('menu'), $par) }}
            </div>
        </div>
    </div>
  </div>s
@endsection

@section('scripts')
<script>
    $(function(){
        /*$('body').attr('data-spy', 'scroll')
                 .attr('data-target', '#myScrollspy')
                 .attr('data-offset', '170');*/
        $('body').scrollspy({ 
            target: "#myScrollspy",
            offset: 80
        });

        $('window').on("load", function() { 
            $('body').scrollspy("refresh") 
        });

        $('#myScrollspy ul li a').on('click', function() {
            var scrollPos = $('body>#help-section').find($(this).attr('href')).offset().top;
            $('body,html').animate({
                scrollTop: scrollPos - 70
            }, 0);
            return false;
        });

        var stickyNavTop = $('#myScrollspy').offset().top; 
        var stickyNav = function(){
            var scrollTop = $(window).scrollTop();         
            if (scrollTop > stickyNavTop) { 
                $('#myScrollspy').addClass('affix');
                $('#myScrollspy .nav .nav').hide();
                /*$('#myScrollspy li.active').closest('ul').show();*/
                $('#myScrollspy li.active').find('ul').show();
            } else {
                $('#myScrollspy').removeClass('affix');
            }
        };
        stickyNav();
        $(window).scroll(function() {
            stickyNav();
        });
    });
</script>
@endsection