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
            $('.modal-body').html(response);
        })
    });

    $('.js-modal-submit').on('click', function () {
        let form = $('.modal-body').find('form');

        $.post(form.attr('action'), form.serialize(), function() {
            showSuccessAndReload();
        })
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
