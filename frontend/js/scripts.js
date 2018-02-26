$('body').on('click', '#logout', function () {
    event.preventDefault();
    $
        .ajax({
            url: '../rest/rest.php/AdminUser/logout',
            type: 'POST'
        })
        .done(function (response) {
            window.location.href = 'index.php?action=users'
        })
        .fail(function (error) {
            var json = JSON.parse(error['responseText']);
            $(errorText).html(json.error);
        });
});