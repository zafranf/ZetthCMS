$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if (IS_MOBILE) {
        $('.dropdown-submenu a.submenu').on("click", function(e) {
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });

        $('body').on('click', function() {
            if ($('.sub-menu').css('display') == "block") {
                $('.sub-menu').css('display', 'none');
            }
        });
    }

    $('a').on('click', function() {
        if (!CONNECT && $(this).attr('href') != "#") {
            return false;
        }
    });

    $('#app-navbar-collapse').find('.active').parent().parent().parent().addClass('active')
});

function _tc() {
    setTimeout(function() {
        _tc();
    }, 1000 * 30);

    $.ajax({
        url: SITE_URL + "/tc.html",
        cache: false
    }).done(function(data) {
        $('#status-server').removeClass('bg-danger').addClass('bg-success').text('Connected');
        CONNECT = true;
    }).fail(function() {
        $('#status-server').removeClass('bg-success').addClass('bg-danger').text('Disconnected');
        CONNECT = false;
    });
}

function _get_slug(txt) {
    return txt.trim()
        .replace(/\s+/g, ' ')
        .replace(/\W/g, ' ')
        .replace(/\s+/g, '-')
        .replace(/\-$/, '')
        .toLowerCase();
}

function _delete(ID = 0, PAGE = '') {
    if (!CONNECT) {
        return false;
    }

    var formDel = '<form id="form-delete" class="form-delete" action="' + SITE_URL + '/' + PAGE + '/' + ID + '" method="post">';
    formDel += '<input type="hidden" name="_method" value="DELETE">';
    formDel += '<input type="hidden" name="_token" value="' + TOKEN + '">';
    formDel += '<label style="font-weight:normal;"><input type="checkbox" name="hard_delete"> Delete permanently</label>';
    formDel += '</form>';

    swal({
        title: "Are you sure?",
        html: formDel,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: "Yes, delete it!"
    }).then(function(isConfirm) {
        if (isConfirm) {
            $('#form-delete').submit();
        }
    });
}

function _remove(id) {
    $(id).remove();
}

function _open_window(url, w = 700, h = 260) {
    window.open(url, '_blank', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, width=' + w + ', height=' + h);
}