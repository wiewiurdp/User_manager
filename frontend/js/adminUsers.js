var errorText =  $('#error');

$('body').on('click', '#singIn', function () {
    event.preventDefault();

    var email = $('#email').val(),
        password = $('#password').val();

    var singinCheck = {
        email: email,
        password: password
    };

        $
        .ajax({
            url: '../rest/rest.php/AdminUser/singin',
            type: 'POST',
            dataType: 'json',
            data: singinCheck
        })
        .done(function (response) {
            window.location.href = 'index.php?action=users'
        })
        .fail(function (error) {
            var json = JSON.parse(error['responseText']);
           $(errorText).html(json.error);
        });
});

$('body').on('click', '#register', function () {
    event.preventDefault();

    var username = $('#username').val(),
        email = $('#email').val(),
        password = $('#password').val(),
        passwordCheck = $('#passwordCheck').val();

    var newAdminUser = {
        username: username,
        email: email,
        password: password,
        passwordCheck: passwordCheck
    };

    $
        .ajax({
            url: '../rest/rest.php/AdminUser/register',
            type: 'POST',
            dataType: 'json',
            data: newAdminUser
        })
        .done(function (response) {
            window.location.href = 'index.php'
        })
        .fail(function (error) {
            var json = JSON.parse(error['responseText']);
            $(errorText).html(json.error);
        });
});
$('body').on('click', '#changePassword', function () {
    event.preventDefault();

    var oldPassword = $('#oldPassword').val(),
        newPassword = $('#newPassword').val(),
        passwordCheck = $('#passwordCheck').val();

    var changePassword = {
        oldPassword: oldPassword,
        newPassword: newPassword,
        passwordCheck: passwordCheck
    };

    $
        .ajax({
            url: '../rest/rest.php/AdminUser/changePassword',
            type: 'POST',
            dataType: 'json',
            data: changePassword
        })
        .done(function (response) {
            window.location.href = 'index.php?action=users'
        })
        .fail(function (error) {
            var json = JSON.parse(error['responseText']);
            $(errorText).html(json.error);
        });
});

