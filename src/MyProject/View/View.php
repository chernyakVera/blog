<?php

namespace MyProject\View;

class View
{
    /**
     * @var string
     */

    /** путь до шаблона $templatesPath попадает из UsersController или
     * ArticlesController (при создании объекта класса View в конструкторе)
     */
    private $templatesPath;

    private $extraVars = []; 

    public function __construct(string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
    }



    /** Сеттер для свойства $extraVars.
     * Это будет ассоциативный массив ['name' => $value]
     */
    public function setVar(string $name, $value): void
    {
        $this->extraVars[$name] = $value;
    }



    /** имя шаблона и массив получаем из любого метода и класса,
     * которые хотят создать страничку.
     */
    public function renderHtml(string $templateName, array $vars = [], int $code = 200)
        
    {
        http_response_code($code);

        extract($this->extraVars); // пока не понимаю к чему эти данные
        extract($vars);

        ob_start();
        $varPath = $this->templatesPath . '/' . $templateName;
        include $varPath;
        $buffer = ob_get_contents();
        ob_end_clean(); 

        echo $buffer;
        $a = 1;
    }
}