<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $users = User::loadAll($conn, isset($secondArg) ? $secondArg : null);
    $jsonUsers = [];
    foreach ($users as $user) {
        $jsonUsers[] = json_decode(json_encode($user), true);
    }
    $response = ['success' => $jsonUsers];

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User($conn);
    $user->setName($_POST['name']);
    $user->setSurname($_POST['surname']);
    $user->setAddress($_POST['address']);
    $user->setUsername($_POST['username']);
    $user->setPassword($_POST['password']);
    $user->setEmail($_POST['email']);
    $user->save();

    $response = ['success' => [json_decode(json_encode($user), true)]];

} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"), $patchVars);
    $userToEdit = User::loadAll($conn, $secondArg)[0];
    $userToEdit->setName($patchVars['name']);
    $userToEdit->setSurname($patchVars['surname']);
    $userToEdit->setAddress($patchVars['address']);
    $userToEdit->setUsername($patchVars['username']);

    $userToEdit->setPassword($patchVars['password']);
    $userToEdit->setEmail($patchVars['email']);
    $userToEdit->save();

    $response = ['success' => [json_decode(json_encode($userToEdit), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $userToDelete = User::loadAll($conn, $secondArg)[0];
    $userToDelete->delete();

    $response = ['success' => 'deleted'];
} else {
    $response = ['error' => 'Wrong request method'];
}
