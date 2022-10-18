<?php


namespace MyProject\Controllers;


use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Articles\Comment;
use MyProject\Models\Users\UsersAuthService;

class CommentsController extends AbstractController
{

    /** Метод для осуществления комментирования статьи по id */
    public function comment(int $articleId): void
    {
        try {
            $comment = Comment::createCommentFromArray($_POST, $this->user, $articleId);
        } catch (InvalidArgumentException $e) {
            $article = Article::getById($articleId);
            $this->view->renderHtml(
                '/articles/view.php', ['error' => $e->getMessage(), 'article' => $article]);
            return;
        }
        header('Location: /articles/' . $articleId .
            '#comment' . $comment->getId());
        exit();
    }



    public function edit(int $commentId)
    {
        $comment = Comment::getById($commentId);
        $article = Article::getById($comment->getArticleId());

        if($comment === null) {
            throw new NotFoundException();
        }

        if(!empty($_POST)) {
            try {
                $comment->updateCommentFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml(
                    'articles/commentEdit.php',
                    ['error' => $e->getMessage()]);
                return;
            }
            header('Location: /articles/' . $article->getId());
            exit();
        }
        $this->view->renderHtml(
            'articles/commentEdit.php', ['comment' => $comment]);
    }


    public function getAllComments()
    {
        $comments = Comment::findAll();
        $this->view->renderHtml('adminPage/allComments.php',
            ['comments' => $comments, 'user' => UsersAuthService::getUserByToken()]);
    }




    public function deleteComment(int $commentId)
    {
        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException('Такого комментария не существует.');
        } else {
            $comment->delete();
            header('Location: /comments/all');
            exit();
        }

    }

}











