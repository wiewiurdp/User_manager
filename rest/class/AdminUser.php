<?php

class AdminUser implements JsonSerializable
{
    private $id, $username, $hashPassword, $email;

    public static $db;

    public function __construct(PDO $db)
    {
        self::$db = $db;

        $this->id = -1;
        $this->username = '';
        $this->hashPassword = '';
        $this->email = '';
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getHashPassword()
    {
        return $this->hashPassword;
    }

    public function setHashPassword($password)
    {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT, ['COST' => 9]);
        $this->hashPassword = $hashPassword;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function save()
    {
        if ($this->id == -1) {
            $sql = "INSERT INTO adminUser (username, email, hashPassword) VALUES (:username,:email,:hashPassword)";
            $prepare = self::$db->prepare($sql);
            $result = $prepare->execute(['username' => $this->username, 'email' => $this->email, 'hashPassword' => $this->hashPassword,]);
            $this->id = self::$db->lastInsertId();

            return (bool)$result;
        } else {
            $sql = "UPDATE adminUser SET username=:username, email=:email, hashPassword=:hashPassword WHERE id=:id";
            $stmt = self::$db->prepare($sql);
            $result = $stmt->execute(['id' => $this->id, 'username' => $this->username, 'email' => $this->email, 'hashPassword' => $this->hashPassword]);
            if ($result === true) {
                return true;
            }
        }
        return false;
    }

    public function delete()
    {
        if ($this->id != -1) {
            $sql = "DELETE FROM adminUser WHERE id=:id";
            $stmt = self::$db->prepare($sql);
            $result = $stmt->execute(['id' => $this->id]);

            if ($result === true) {
                $this->id = -1;

                return true;
            }
            return false;
        }
        return true;
    }

    static public function hashPassword($password)
    {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT, ['COST' => 9]);
        return $hashPassword;
    }

    static public function loadAdminUserById(PDO $db, $id)
    {
        $sql = "SELECT * FROM adminUser WHERE id=:id";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute(['id' => $id]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $loadAdminUser = new AdminUser($db);
            $loadAdminUser->id = $row['id'];
            $loadAdminUser->username = $row['username'];
            $loadAdminUser->hashPassword = $row['hashPassword'];
            $loadAdminUser->email = $row['email'];

            return $loadAdminUser;
        }
        return null;
    }

    static public function showAdminUserByEmail(PDO $db, $email)
    {
        $stmt = $db->prepare('SELECT * FROM adminUser WHERE email=:email');
        $result = $stmt->execute(['email' => $email]);

        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $loadedAdminUser = new AdminUser($db);
            $loadedAdminUser->id = $row['id'];
            $loadedAdminUser->username = $row['username'];
            $loadedAdminUser->hashPassword = $row['hashPassword'];
            $loadedAdminUser->email = $row['email'];
            return $loadedAdminUser;
        }

        return null;
    }

    public function jsonSerialize()
    {
        return [
          'id' => $this->id,
          'username' => $this->username,
          'hashPassword' => $this->hashPassword,
          'email' => $this->email,
          ''
        ];
    }

}

