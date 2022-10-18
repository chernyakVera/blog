<?php


namespace MyProject\Controllers;

use MyProject\Exceptions\Forbidden;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Users\User;


class AdminController extends AbstractController
{


    public function cabinet()
    {
        try {
            $user = User::getById($this->user->getId());

            if($this->user === null) {
                throw new UnauthorizedException(
                    'Для того, чтобы попасть в кабинет администратора, вам нужно авторизоваться');
            }

            if(!$this->user->isAdmin()) {
                throw new Forbidden(
                    'В кабинет администратора могут попасть только пользователи с уровнем доступа администратора.');
            }

        } catch (UnauthorizedException $e) {
            $this->view->renderHtml('adminPage/adminPage.php', ['error' => $e->getMessage()]);
            return;
        } catch (Forbidden $e) {
            $this->view->renderHtml('adminPage/adminPage.php', ['error'=> $e->getMessage(), 'user'=> $user]);
            return;
        }

        $this->view->renderHtml(
            'adminPage/adminPage.php', ['user' => $user]);
        }


}