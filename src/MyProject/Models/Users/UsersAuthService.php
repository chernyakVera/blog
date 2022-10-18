<?php

namespace MyProject\Models\Users;

class UsersAuthService
{


    public static function createToken(User $user): void
    {
        $token = $user->getId() . ':' . $user->getAuthToken();
        setcookie('token', $token, 0, '/', '', false, true);
    }



    public static function getUserByToken(): ?User
    {
        $token = $_COOKIE['token'] ?? ''; // использование тернарного оператора вида exp1 ?? exp3

        if (empty($token)) {
            return null;
        }

        [$userId, $authToken] = explode(':', $token, 2);

        $user = User::getById((int)$userId); // для последующей проверки на существавоние такого пользователя в БД

        if ($user === null) {
            return null;
        }

        if ($user->getAuthToken() !== $authToken) {
            return null;
        }

        return $user;
    }
}