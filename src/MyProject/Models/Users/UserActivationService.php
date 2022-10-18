<?php


namespace MyProject\Models\Users;

use MyProject\Services\Db;

/** Класс, который позволит нам создавать новые коды активации для
 * пользователей (и следовательно новые строки в таблице БД),
 * а также проверять код активации для конкретного пользователя.
 */
class UserActivationService
{
    private const TABLE_NAME = 'users_activation_cods';


    public static function createActivationCode(User $user): string
    {
        $code = bin2hex(random_bytes(16));

        $sql = 'INSERT INTO `' . self::TABLE_NAME . '` (user_id, code) 
                VALUES (:user_id, :code)';
        $db = Db::getInstance();
        $db->query($sql, ['user_id' => $user->getId(), 'code' => $code]);

        return $code;
    }




    public static function checkActivationCode(User $user, string $code): bool
    {
        $sql = 'SELECT * FROM `' . self::TABLE_NAME .
               '` WHERE user_id = :user_id AND code = :code';

        $db = Db::getInstance();
        $result = $db->query($sql,
            ['user_id' => $user->getId(), 'code' => $code]);

        return !empty($result);
    }



    public static function deleteActivationCode(int $userId)
    {
        $sql = 'DELETE FROM `' . self::TABLE_NAME . '` ' .
               'WHERE user_id = :userId';

        $db = Db::getInstance();
        $db->query($sql, [':userId' => $userId]);
    }
}