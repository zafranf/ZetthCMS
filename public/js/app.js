$('document').ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    /* $('.dropdown-menu a.dropdown-item').on('click', function(e) {
        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');


        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
            $('.dropdown-menu .show').removeClass("show");
        });


        return false;
    }); */
});

function _get_status_text(status = 0, par = []) {
    /* check custom parameter */
    if (par.length == 0) {
        par = ['Nonaktif', 'Aktif'];
    }

    /* generate text */
    if (status == 0) {
        return '<span class="tag bg-danger text-center text-white">' + par[0] + '</span>';
    } else {
        return '<span class="tag bg-success text-cente text-white"">' + par[1] + '</span>';
    }
}

function _delete(URL = '') {
    var formDel = '<form id="form-delete" class="form-delete" action="' + URL + '" method="post">';
    formDel += '<input type="hidden" name="_method" value="DELETE">';
    formDel += '<input type="hidden" name="_token" value="' + TOKEN + '">';
    // formDel += '<label style="font-weight:normal;"><input type="checkbox" name="hard_delete"> Delete permanently</label>';
    formDel += '</form>';

    swal({
        title: "Hapus data?",
        html: formDel,
        type: "warning",
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
        confirmButtonText: "Hapus!"
    }).then(function(isConfirm) {
        if (isConfirm.value) {
            $('#form-delete').submit();
        }
    });
}