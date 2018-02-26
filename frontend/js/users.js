$(function () {

    var $addUser = $('#add');
    var $userList = $('#userList');

    $('body').on('click', '#delete', function () {
        var id = $(this).data('id');
        var that = $(this);
        $
            .ajax({
                url: '../rest/rest.php/user/' + id,
                type: 'DELETE'
            })
            .done(function (response) {
                that.closest('.listItem').remove();
            })
            .fail(function (error) {
                var json = JSON.parse(error['responseText']);
                $(errorText).html(json.error);
            });
    });

    $('body').on('click', '#edit', function () {
        $(this).closest('.listItem').children().find('.edit').removeClass('hidden');
        $(this).closest('.listItem').children().find('.edit').prev().prev().addClass('hidden');
        $(this).closest('.listItem').children().find('#edit').addClass('hidden');

    });
    $('body').on('click', '#applyChanges', function () {
        var id = $(this).data('id');
        var that = $(this);
        var nameEdited = $(this).closest('.listItem').find('#nameEdited').val();
        var surnameEdited = $(this).closest('.listItem').find('#surnameEdited').val();
        var addressEdited = $(this).closest('.listItem').find('#addressEdited').val();
        var usernameEdited = $(this).closest('.listItem').find('#usernameEdited').val();
        var passwordEdited = $(this).closest('.listItem').find('#passwordEdited').val();
        var emailEdited = $(this).closest('.listItem').find('#emailEdited').val();

        var updateUser = {
            name: nameEdited,
            surname: surnameEdited,
            address: addressEdited,
            username: usernameEdited,
            password: passwordEdited,
            email: emailEdited
        };
        $
            .ajax({
                url: '../rest/rest.php/user/' + id,
                type: 'PUT',
                dataType: 'json',
                data: updateUser
            })
            .done(function (response) {
                $(that).closest('.listItem').find('#fieldName').html(nameEdited);
                $(that).closest('.listItem').find('#fieldSurname').html(surnameEdited);
                $(that).closest('.listItem').find('#fieldAddress').html(addressEdited);
                $(that).closest('.listItem').find('#fieldUsername').html(usernameEdited);
                $(that).closest('.listItem').find('#fieldPassword').html(passwordEdited);
                $(that).closest('.listItem').find('#fieldEmail').html(emailEdited);

                $(that).closest('.listItem').children().find('.edit').addClass('hidden');
                $(that).closest('.listItem').children().find('.edit').prev().prev().removeClass('hidden');
                $(that).closest('.listItem').children().find('#edit').removeClass('hidden');
            })
            .fail(function (error) {
                var json = JSON.parse(error['responseText']);
                $(errorText).html(json.error);
            });
    });

    $addUser.on('submit', function (event) {
        event.preventDefault();

        var name = $('#name').val(),
            surname = $('#surname').val(),
            address = $('#address').val(),
            username = $('#username').val(),
            password = $('#password').val(),
            email = $('#email').val();

        var newUser = {
            name: name,
            surname: surname,
            address: address,
            username: username,
            password: password,
            email: email
        };

        $
            .ajax({
                url: '../rest/rest.php/user',
                type: 'POST',
                dataType: 'json',
                data: newUser
            })
            .done(function (response) {
                renderUser(response.success[0]);
            })
            .fail(function (error) {
                var json = JSON.parse(error['responseText']);
                $(errorText).html(json.error);
            });
    });

    function getUsers() {
        $
            .ajax({
                url: '../rest/rest.php/user',
                type: 'GET'
            })
            .done(function (response) {
                for (var i = 0; i < response.success.length; i++) {
                    renderUser(response.success[i]);
                }
            })
            .fail(function (error) {
                var json = JSON.parse(error['responseText']);
                $(errorText).html(json.error);
            });
    }

    function renderUser(user) {
        var string = `
                <tr class="listItem">
                    <td>
                        <p id="fieldName">${user.name}</p><br>
                        <p class="edit hidden"><input type="text" name="name" id="nameEdited" value="${user.name}"></p>
                    </td>
                    <td>
                       <p id="fieldSurname">  ${user.surname}</p><br>
                        <p class="edit hidden"><input type="text" name="surname" id="surnameEdited" value="${user.surname}"></p>
                    </td>
                    <td>
                      <p id="fieldAddress">  ${user.address}</p><br>
                       <p class="edit hidden"><input type="text" address="address" id="addressEdited" value="${user.address}"></p>
                    </td>
                    <td>
                        <p id="fieldUsername"> ${user.username}</p><br>
                          <p class="edit hidden"><input type="text" username="username" id="usernameEdited" value="${user.username}"></p>
                    </td>
                    <td>
                       <p id="fieldPassword">  ${user.password}</p><br>
                          <p class="edit hidden"><input type="password" password="address" id="passwordEdited" value="${user.address}"></p>
                    </td>
                    <td>
                        <p id="fieldEmail"> ${user.email}</p><br>
                          <p class="edit hidden"><input type="email" email="email" id="emailEdited" value="${user.email}"></p>
                        </td>
                        <td>
                        <button id="edit" class="btn btn-primary" data-id = '${user.id}'>Edit</button>
                        <button id="delete" class="btn btn-primary" data-id = '${user.id}'>Delete</button><br>
                        <button id="applyChanges" class="edit hidden btn btn-primary" data-id = '${user.id}'>Apply Changes</button>
                    </td>
                </tr>
            `;
        $userList.html($userList.html() + string)
    }
    getUsers();
});

