<?php
$result = '';
$error = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($secondArg == 'singin') {
        $email = $_POST['email'];
        $password = AdminUser::hashPassword($_POST['password']);
        $adminUser = AdminUser::showAdminUserByEmail($conn, $email);
        if ($adminUser) {
            if (password_verify($_POST['password'], $adminUser->getHashPassword())) {
                $loginCheck = 1;
                $_SESSION['logged'] = true;
                $_SESSION['email'] = $adminUser->getEmail();
                $_SESSION['id'] = $adminUser->getId();
                $result = 'logged';
            } else {
                $error = 'Wrong password';
            }
        } else {
            $error = 'Incorrect email';
        }
    } elseif ($secondArg == 'register') {
        if ($_POST['password'] === $_POST['passwordCheck']) {
            $email = $_POST['email'];
            $emailCheck = AdminUser::showAdminUserByEmail($conn, $email);
            if ($emailCheck) {
                $error = 'User with this email already exist';
            } else {
                $adminUser = new AdminUser($conn);
                $adminUser->setEmail($_POST['email']);
                $adminUser->setUsername($_POST['username']);
                $adminUser->setHashPassword($_POST['password']);
                $adminUser->save();
                $result = 'registered';
            }
        } else {
            $error = 'Re-entered password should be identical. ';
        }
    } elseif ($secondArg == 'changePassword') {
        $adminUser = AdminUser::loadAdminUserById($conn, $_SESSION['id']);
        $username = $adminUser->getUsername();
        $email = $adminUser->getEmail();
        if (isset($_POST['newPassword']) && isset($_POST['passwordCheck'])) {
            if ($_POST['newPassword'] === $_POST['passwordCheck'] && password_verify($_POST['oldPassword'], $adminUser->getHashPassword())) {
                $adminUser->setHashPassword($_POST['newPassword']);
                $adminUser->save();
                $result = 'passwordChanged';
            } else {
                $error = 'Wrong Input';
            }
        }
    } elseif ($secondArg == 'logout') {
        $_SESSION['logged'] = false;
        $_SESSION['email'] = false;
        $_SESSION['id'] = false;
        $result = 'loggedout';
    }
} else {
    $response = ['error' => 'Wrong request method'];
}

if ($error != null) {
    $response = ['error' => $error];
} else {
    $response = ['succeess' => [json_decode(json_encode($result), true)]];
}
