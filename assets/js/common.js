$(function () {
    
    $('.custom_tooltip').tooltip();
    
    $('.e_eliminar').on('click', function (e) {
        e.preventDefault();
        var id_eliminar = $(this).attr('data-bind');
        var id_pagina = $(this).attr('href');
        $('#id_eliminar').val(id_eliminar);
        $('#id_pagina').val(id_pagina);
        $('#modal_eliminar').modal('show');
    });

    $('.b_eliminar').on('click', function (e) {
        e.preventDefault();
        var id_eliminar = $('#id_eliminar').val();
        var url = $('#id_pagina').val();
        var datos = {id: id_eliminar};

        $.ajax({
            url: url, type: 'post', cache: false, data: datos,
            success: function (data) {
                location.reload();
            }
        });
    });

});
