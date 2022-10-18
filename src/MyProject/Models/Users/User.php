<?php

namespace MyProject\Models\Users;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\UserActivationService;
use MyProject\Services\Db;

/** Класс, который отражает таблицу `users` из БД
 и наследуется от абстрактного класса ActiveRecordEntity */
class User extends ActiveRecordEntity
{
    /** @var string */
    protected $nickname;

    /** @var string */
    protected $email;

    /** @var int */
    protected $isConfirmed;

    /** @var string */
    protected $role;

    /** @var string */
    protected $userPic;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $createdAt;



    protected static function getTableName(): string
    {
        return 'users';
    }


    public function getRole(): string
    {
        return $this->role;
    }


    public function getEmail(): string
    {
        return $this->email;
    }


    public function getNickname(): string
    {
        return $this->nickname;
    }


    public function getAuthToken(): string
    {
        return $this->authToken;
    }


    public function getUserPicName(): string
    {
        return $this->userPic;
    }


    public static function signUp(array $userData): User
    {
        if(empty($userData['nickname'])) {
            throw new InvalidArgumentException('Не передан nickname');
        }


        if(!preg_match('/^[a-zA-Z0-9]+$/', $userData['nickname'])) {
            throw new InvalidArgumentException(
                'Nickname может состоять только из букв латинского
                алфавита любого регистра и цифр');
        }

        if(empty($userData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }


        if(!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                'Передан некорректный email');
        }

        if(empty($userData['password'])) {
            throw new InvalidArgumentException('Не передан password');
        }


        if(mb_strlen($userData['password']) < 8) {
            throw new InvalidArgumentException(
                'Пароль должен содержать не менее 8 символов');
        }

        if(static::findOneByColumn(
            'nickname', $userData['nickname']) !== null) {
            throw new InvalidArgumentException(
                'Пользователь с таким nickname уже существует');
        }

        if(static::findOneByColumn(
            'email', $userData['email']) !== null) {
            throw new InvalidArgumentException(
                'Пользователь с таким email уже существует');
        }


        $user = new User();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->isConfirmed = False;
        $user->role = 'user';
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));

        $user->save();

        return $user;
    }


    public static function upload(array $fileData, User $user): string
    {
        if (array_key_exists('picture', $fileData)) {
            if ($fileData['picture']['error'] === UPLOAD_ERR_OK) {
                $targetDir = '/OSPanel/OpenServer/domains/myproject.loc/www/media/';
                $file = $fileData['picture']['name'];
                $path = pathinfo($file);
                $filename = $path['filename'];
                $ext = $path['extension'];
                $temp_name = $fileData['picture']['tmp_name'];
                $path_filename_ext = $targetDir . $filename . '.' . $ext;

                if(file_exists($path_filename_ext)) {
                    $error =  'Файл с таким именем уже существует';
                } else {
                    move_uploaded_file($temp_name, $path_filename_ext);
//                    echo 'Файл успешно загружен!';
                }
            }
        }

        $user->userPic = $filename;
        $user->save();

        return $filename;

    }



    public function activate(): void
    {
        $this->isConfirmed = true;
        $this->save();
    }



    public static function login(array $loginData): User
    {
        if (empty($loginData['email'])) {
            throw new InvalidArgumentException('Не передан email');
        }

        if (empty($loginData['password'])) {
            throw new InvalidArgumentException('Не передан пароль');
        }

        $user = User::findOneByColumn('email', $loginData['email']);
        if ($user === null) {
            throw new InvalidArgumentException(
                'Пользователя с таким email не существует');
        }

        if (!password_verify($loginData['password'], $user->getPasswordHash())) {
            throw new InvalidArgumentException('Неверный пароль');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }



    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }



    private function refreshAuthToken()
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }



    public function isAdmin(): bool
    {
        if($this->getRole() === 'admin') {
            return true;
        } else {
            return false;
        }
    }

}




















