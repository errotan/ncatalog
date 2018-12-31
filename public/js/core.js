/* Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
   Licensed under the MIT license. */

function showSuccessAndReload() {
    alert('Művelet sikeres!');
    location.reload();
}

function showSuccessAndGoHome() {
    alert('Művelet sikeres!');
    location.replace('/');
}

function modalLoad(element, lister) {
    $('#modal' + (lister ? '' : '-lister')).modal('hide');

    let url = $(element).data('url');

    $.get(url, function(response) {
        $('#modal' + (lister ? '-lister' : '') + ' .modal-body').html(response);
    });
}

$(function() {
    $(document).on('click', '.js-modal-load', function () {
        modalLoad(this, false);
    });

    $(document).on('click', '.js-modal-lister-load', function () {
        modalLoad(this, true);
    });

    $('.js-modal-submit').on('click', function () {
        let form = $('#modal .modal-body').find('form');
        let values = new FormData(form[0]);

        $.ajax(form.attr('action'), {
            processData: false,
            cache: false,
            contentType: false,
            type: 'POST',
            data: values
        }).done(function() {
            showSuccessAndReload();
        }).fail(function() {
            alert('Hiba történt a kérés elküldésekor!');
        });
    });

    $('.js-confirm').on('click', function () {
        if (confirm('Biztos benne, hogy végrehajtja a műveletet?')) {
            let url = $(this).data('url');

            $.get(url, function() {
                showSuccessAndGoHome();
            })
        }
    });
});
