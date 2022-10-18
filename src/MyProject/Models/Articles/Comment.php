<?php


namespace MyProject\Models\Articles;


use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Services\Db;
use MyProject\Models\Articles\Article;

class Comment extends ActiveRecordEntity
{
    /** @var int  */
    protected $userId;

    /** @var int  */
    protected $articleId;

    /** @var string  */
    protected $text;


    protected static function getTableName(): string
    {
        return 'comments';
    }


    public function setUserId(User $user)
    {
        $this->userId = $user->getId();
    }

    public function setArticleId(int $articleId)
    {
        $this->articleId = $articleId;
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }



    public function getUserId(): int
    {
        return $this->userId;
    }


    public function getUser(): User
    {
        return User::getById($this->userId);
    }


    public function getText(): string
    {
        return $this->text;
    }


    public function getArticleId(): int
    {
        return $this->articleId;
    }


    public function getArticleName(int $articleId): string
    {
        $db = Db::getInstance();
        $sql = 'SELECT `name` FROM `articles` 
                INNER JOIN `comments` ON articles.id = comments.article_id
                WHERE article_id = :article_id
                LIMIT 1;';
        $article = $db->query($sql,
            [':article_id' => $articleId], Article::class);
        $articleName = $article[0];

        return  $articleName->getName();
    }


    public static function createCommentFromArray(array $fields, User $user, int $articleId): Comment
    {
        if(empty($fields['name'])) {
            throw new InvalidArgumentException(
                'Не передано имя комментатора.');
        }

        if(empty($fields['text'])) {
            throw new InvalidArgumentException(
                'Не передан текст комментария.');
        }

        $comment = new Comment();

        $comment->setUserId($user);
        $comment->setArticleId($articleId);
        $comment->setText($fields['text']);

        $comment->save();

        return $comment;
    }





    public function updateCommentFromArray(array $fields): Comment
    {
        if(empty($fields['text'])) {
            throw new InvalidArgumentException(
                'Не передан текст комментария.');
        }

        $this->setText($fields['text']);

        $this->save();

        return $this;
    }


}















