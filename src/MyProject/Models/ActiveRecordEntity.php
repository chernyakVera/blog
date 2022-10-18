<?php

namespace MyProject\Models;

use MyProject\Services\Db;

/** Используем именно абстрактный класс, т.к. нам не нужны экземпляры от него.
 * Интересует только наследование для классов Article и User.
 */
abstract class ActiveRecordEntity
{
    /**@var int */
    protected $id;

    /** @var string */
    protected $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    abstract protected static function getTableName(): string;


    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }



    private function underscoreToCamelCase(string $sourse): string
    {
        return lcfirst(str_replace('_', '', (ucwords($sourse, '_'))));
    }


    /**
     * @return static[]
     */
    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM ' . static::getTableName(), [], static::class);
    }


    public static function findAllCommentsByArticleId(int $articleId): array
    {
        $db = Db::getInstance();
        $sql = 'SELECT * FROM `comments` WHERE `article_id` = :articleId';
        $commentsFromDb = $db->query($sql, [':articleId' => $articleId], static::class);

        return $commentsFromDb;
    }


    /**
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();

        /** @var  $entities */
        $entities = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }



    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/',
            '_$0', $source));
    }


    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        $mappedProperties = [];

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderScore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderScore] = $this->$propertyName;
        }
        return $mappedProperties;
    }


    public function save()
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();

        if($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }

    }



    private function update(array $mappedProperties): void
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;

        foreach ($mappedProperties as $column => $value) {

            $param = ':param' . $index; // :param1
            $columns2params[] = $column . ' = ' . $param; // column1 = :param1
            $params2values[$param] = $value; // [:param1 => value1]

            $index++;
        }

        $sql = 'UPDATE `' . static::getTableName() .
            '` SET ' . implode(', ', $columns2params) .
            ' WHERE id = ' . $this->id;

        $db = Db::getInstance();
        $db->query($sql, $params2values,static::class);
    }



    private function insert(array $mappedProperties): void
    {
        $filteredProperties = array_filter($mappedProperties);

        $columns = []; // массив для сбора названий столбцов вида [`column`]
        $paramsNames = []; // массив для сбора названий столбцов в качестве параметров
        $params2values = []; // массив для сбора зависимости параметра и значения вида [:column => value]

        foreach ($filteredProperties as $columnName => $value) {
            $columns[] = '`'. $columnName . '`'; // [`column`]
            $paramName = ':' . $columnName; // :column
            $paramsNames[] = $paramName; // [:column]
            $params2values[$paramName] = $value; // [:column => value1]
        }

        $sql = 'INSERT INTO `' . static::getTableName() . '` (' .
            implode(', ', $columns) . ') VALUES (' .
            implode(', ', $paramsNames) . ');';

        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
        $this->id = $db->getLastInsertId();
        $this->refresh();
    }


    private function refresh()
    {
        $objectFromDb = static::getById($this->id);

        foreach ($objectFromDb  as $column => $value)
        {
            $this->$column = $value;
        }
    }



    public function delete()
    {
        $currentId = $this->id;

        $sql = 'DELETE FROM `' . static::getTableName() . '` ' .
            'WHERE id = :id';

        $db = Db::getInstance();
        $db->query($sql, [':id' => $currentId]);

        $this->id = null;
    }



    public function deleteArticleWithComments()
    {
        $currentArticleId = $this->id;
        $sql = 'DELETE `articles`, `comments`
                FROM `articles` 
                INNER JOIN `comments` 
                ON articles.id = comments.article_id
                WHERE articles.id = :id AND article_id = :id';

        $db = Db::getInstance();
        $db->query($sql, [':id' => $currentArticleId]);

        $this->id = null;

    }





    public static function findOneByColumn(string $columnName, $value): ?self
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM `' . static::getTableName() .
            '` WHERE `' . $columnName . '` = :value LIMIT 1;',
            [':value' => $value],
            static::class
        );

        if($result === []) {
            return null;
        } else {
            return $result[0];
        }
    }




    /** Метод для пагинации: он будет принимать на вход количество записей
     * на одной странице, подсчитывать, сколько всего записей в БД и
     * возвращать количество страниц.
     */
    public static function getPagesCount(int $itemsPerPage): int
    {
        $db = Db::getInstance();
        $sql = 'SELECT COUNT(*) AS cnt FROM ' . static::getTableName() . ' ;';
        $result = $db->query($sql);

        /* Функ. ceil() округляет число в большую сторону. */
        return ceil($result[0]->cnt / $itemsPerPage);
    }




    /** Метод для пагинации: выводит статьи принадлежащие конкретной странице */
    public static function getPage(int $pageNum, int $itemsPerPage): array
    {
        $db = Db::getInstance();
        $sql = 'SELECT * FROM `%s` ORDER BY id DESC LIMIT %d OFFSET %d;';

        /* Функ. sprintf() возвращает отформатированную строку,
        изначально сставленную как шаблон (в формате format) */
        $articlesOnPage = $db->query(
            sprintf(
                $sql, static::getTableName(), $itemsPerPage,
                ($pageNum - 1) * $itemsPerPage),
            [], static::class);

        return $articlesOnPage;
    }
}
