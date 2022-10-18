<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\Forbidden;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Users\UserActivationService;
use MyProject\Models\Users\UsersAuthService;
use MyProject\Services\EmailSender;
use MyProject\View\View;
use MyProject\Models\Users\User;
use PHPMailer\PHPMailer\Exception;

/** Класс-конроллер для работы с пользователями */
class UsersController extends AbstractController
{
    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml(
                    'users/signUp.php', ['error' => $e->getMessage()]);

                return;
            }

            if ($user instanceof User) {
                $code = UserActivationService::createActivationCode($user);

                EmailSender::send($user, 'Активация',
                    'userActivation.php',
                    ['userId' => $user->getId(), 'code' => $code]);

                $this->view->renderHtml('users/signUpSuccessful.php');
                return;
            }
        }
        $this->view->renderHtml('users/signUp.php');

        if(!empty($_FILES)) {
            $avatarName = User::upload($_FILES, $this->user);
        }
    }


    public function activate(int $userId, string $activateCode)
    {
        try {
                $user = User::getById($userId);

                if ($user === null) {
                    throw new \Exception(
                        'Такого пользователя не существует.');
                }

                $isCodeValid = UserActivationService::checkActivationCode($user, $activateCode);
                if (!$isCodeValid) {
                    throw new \Exception(
                        'Такого кода активации не существует');
                }
            } catch (\Exception $e) {
                $view = new View(__DIR__ . '/../../../templates/errors');
                $view->renderHtml('userNotFound.php', ['error' => $e->getMessage()]);
                return;
            }


            if ($isCodeValid) {
                $user->activate();
                $this->view->renderHtml('/users/activateSuccesful.php');
                UserActivationService::deleteActivationCode($userId);
            }
    }


    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /'); // oтправка HTTP-заголовка
                exit(); // вывести сообщение и прекратить выполнение текущего скрипта
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml(
                    'users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('users/login.php');
    }


    public function logout()
    {
        session_start();
        session_destroy();
        setcookie('token', '', -1, '/', '', false, true);
        header('Location: /');
        exit();
    }



    public function addAvatar()
    {
        if($this->user instanceof User) {
            if(!empty($_FILES)) {
                $avatarName = User::upload($_FILES, $this->user);
            } else {
                $this->view->renderHtml('/users/cabinet.php');
            }
        } else {
            $this->view->renderHtml('/users/login.php');
        }
    }



    public function cabinet()
    {
        try {
            $user = User::getById($this->user->getId());

            if($this->user === null) {
                throw new UnauthorizedException(
                    'Для того, чтобы попасть в кабинет пользователя, вам нужно авторизоваться');
            }

        } catch (UnauthorizedException $e) {
            $this->view->renderHtml('users/cabinet.php', ['error' => $e->getMessage()]);
            return;
        } catch (Forbidden $e) {
            $this->view->renderHtml('users/cabinet.php', ['error'=> $e->getMessage(), 'user'=> $user]);
            return;
        }

        $this->view->renderHtml(
            'users/cabinet.php', ['user' => $user]);
    }
}















