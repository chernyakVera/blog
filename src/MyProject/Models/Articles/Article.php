<?php

namespace MyProject\Models\Articles;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;

/**Преобразовали класс со статьями в класс,
 * работающий как таблица article из БД
 * (пишем свою ORM)
 * и далее каждый созданный объект этого класса
 * будет соответствовать одной строке из таблицы article из БД
 */
class Article extends ActiveRecordEntity
{
    /**@var int */
    protected $authorId;

    /**@var string */
    protected $name;

    /**@var  string*/
    protected $text;

    /**@var string */
    protected $createdAt;


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }


    public function getShortText(): string
    {
        return mb_substr($this->text, 0, 100, 'UTF-8') . '...';
    }


    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }


    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }


    protected static function getTableName(): string
    {
        return 'articles';
    }


    /** Сеттер(метод, где можно задать новое значение вместо уже существующего)
     * для столбца name.
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }


    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function setAuthorId(int $authorId)
    {
        $this->authorId = $authorId;
    }



    public function setAuthor(User $author)
    {
        $this->authorId = $author->getId();
    }



    public static function createFromArray(array $fields, User $author) : Article
    {
        if(empty($fields['name'])) {
            throw new InvalidArgumentException(
                'Не передано название статьи.');
        }

        if(empty($fields['text'])) {
            throw new InvalidArgumentException(
                'Не передан текст статьи.');
        }

        $article = new Article();

        $article->setAuthor($author);
        $article->setName($fields['name']);
        $article->setText($fields['text']);

        $article->save();

        return $article;
    }


    public function updateFromArray(array $fields): Article
    {

        if(empty($fields['name'])) {
            throw new InvalidArgumentException(
                'Не передано название статьи.');
        }

        if(empty($fields['text'])) {
            throw new InvalidArgumentException(
                'Не передан текст статьи.');
        }


        $this->setName($fields['name']);
        $this->setText($fields['text']);

        $this->save();

        return $this;
    }
}













