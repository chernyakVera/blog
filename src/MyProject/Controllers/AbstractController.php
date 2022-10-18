<?php

namespace MyProject\Controllers;

use MyProject\Models\Users\UsersAuthService;
use MyProject\Models\Users\User;
use MyProject\View\View;

/** Абстрактный класс для выведения приветствия пользователя на страничке
 * или просьбы войти на сайт.
 */
abstract class AbstractController
{
    /** @var View  */
    protected $view;

    /** @var User|null  */
    protected $user;

    public function __construct()
    {
        /* это необходимо для шапки, где мы или здороваемся с авторизованным пользователем, или просим залогиниться неавторизованного */
        $this->user = UsersAuthService::getUserByToken();

        $this->view = new View(__DIR__ . '/../../../templates');
        $this->view->setVar('user', $this->user); // отправляем в шапку имя пользователя
    }
}