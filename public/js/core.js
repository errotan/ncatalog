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

$(function() {
    $('.js-modal-load').on('click', function () {
        let url = $(this).data('url');

        $.get(url, function(response) {
            $('#modal .modal-body').html(response);
        })
    });

    $('.js-modal2-load').on('click', function () {
        let url = $(this).data('url');

        $.get(url, function(response) {
            $('#modal2 .modal-body').html(response);
        })
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
