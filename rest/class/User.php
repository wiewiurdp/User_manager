<?php

/**
 * Class User
 */
class User implements JsonSerializable
{
    private $id, $name, $surname, $address, $username, $password, $email;

    public static $db;

    public function __construct(PDO $db)
    {
        self::$db = $db;

        $this->id = -1;
        $this->name = '';
        $this->surname = '';
        $this->address = '';
        $this->username = '';
        $this->password = '';
        $this->email = '';
    }

    public function save()
    {
        if ($this->id > 0) {
            $sql = "UPDATE users SET name=:name, surname=:surname, address=:address,username=:username, password=:password, email=:email WHERE id=:id";
            $stmt = self::$db->prepare($sql);
            $stmt->execute(
                [
                    'id' => $this->id,
                    'name' => $this->name,
                    'surname' => $this->surname,
                    'address' => $this->address,
                    'username' => $this->username,
                    'password' => $this->password,
                    'email' => $this->email,
                ]
            );
        } else {
            $sql = "INSERT INTO users SET name=:name, surname=:surname, address=:address,username=:username, password=:password, email=:email";
            $stmt = self::$db->prepare($sql);
            $stmt->execute(
                [
                    'name' => $this->name,
                    'surname' => $this->surname,
                    'address' => $this->address,
                    'username' => $this->username,
                    'password' => $this->password,
                    'email' => $this->email,
                ]
            );
            $this->id = self::$db->lastInsertId();
        }

    }

    public function delete()
    {
        $sql = "DELETE FROM users WHERE id=:id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute(
            [
                'id' => $this->id,
            ]
        );

        return $stmt->rowCount() > 0;
    }


    public static function loadAll(PDO $db, $id = null)
    {
        $params = [];
        if (!$id) {
            $sql = "SELECT * FROM users";
        } else {
            $sql = "SELECT * FROM users WHERE id=:id";
            $params = ['id' => $id];
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        $usersList = [];

        foreach ($users as $dbUser) {
            $user = new User($db);
            $user->id = $dbUser->id;
            $user->name = $dbUser->name;
            $user->surname = $dbUser->surname;
            $user->address = $dbUser->address;
            $user->username = $dbUser->username;
            $user->password = $dbUser->password;
            $user->email = $dbUser->email;

            $usersList[] = $user;
        }

        return $usersList;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'address' => $this->address,
            'username' => $this->username,
            'password' => $this->password,
            'email' => $this->email,
            ''
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     *
     * @return $this
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $address
     *
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
}