<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\Forbidden;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Articles\Comment;
use MyProject\Models\Users\User;
use MyProject\View\View;
use MyProject\Models\Users\UsersAuthService;

/** Класс для обработки статьи (будет отдельная страница со статьей) */
class ArticlesController extends AbstractController
{
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);
        $comments = Comment::findAllCommentsByArticleId($articleId);

        if($article === null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php',
            ['article' => $article,
                'comments' => $comments]);

        $a = 1;
    }

    public function getUser(): User
    {
        if(isset($this->user)) {
            return $this->user;
        }
    }



    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);

        if($article === null) {
            throw new NotFoundException();
        }

        if($this->user === null) {
            throw new UnauthorizedException();
        }

        if(!$this->user->isAdmin()) {
            throw new Forbidden(
                'Редактировать статьи могут только пользователи с уровнем доступа admin.');
        }

        if(!empty($_POST)) {
            try {
                $article->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml(
                    'articles/edit.php', ['error'=> $e->getMessage()]);
                return;
            }
            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }
        $this->view->renderHtml(
            'articles/edit.php', ['article'=> $article]);
    }



    public function add(): void
    {
        if($this->user === null) {
            throw new UnauthorizedException();
        }

        if(!$this->user->isAdmin()) {
            throw new Forbidden('Создавать статьи могут только пользователи с уровнем доступа admin');
        }

        if(!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml(
                    'articles/add.php', ['error'=> $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $article->getId(),
                true, 302);
            exit();
        }

        $this->view->renderHtml('/articles/add.php', ['user' => $this->user]);
    }



    public function deleteArticle(int $articleId)
    {
        $article = Article::getById($articleId);

        if($article !== null) {
            $article->deleteArticleWithComments();
        } else {
            echo "Статьи с id = $articleId не существует";
        }

        header('Location: /articles/all', true, 302);
        exit();
    }


    public function getAllArticles()
    {
        $articles = Article::findAll();
        $this->view->renderHtml('adminPage/allArticles.php',
        ['articles' => $articles,
            'user' => UsersAuthService::getUserByToken()]);
    }
}

