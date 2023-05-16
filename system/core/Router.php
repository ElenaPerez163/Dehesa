<?php
class Router
{
    /// PROPIEDADES ///
    private $uri; //array que contendrá nuestra uri
    private $controller; //controlador
    private $method; //método
    private $params; //array de parámetros

    public function __construct()
    {
        //obtener los valores de la uri con  los métodos setters
        $this->setUri();
        $this->setController();
        $this->setMethod();
        $this->setParams();
    }

    /// MÉTODOS SETTERS ///

    public function setUri()
    {
        //usamos la funcion explode de php para separar las diferentes partes
        $this->uri = explode("/", URI);
    }

    public function setController()
    {
        //coger la parte con índice 2 del array (será la que corresponda al controlador)
        $this->controller = empty($this->uri[2]) ? DEFAULT_CONTROLLER : $this->uri[2];
    }

    public function setMethod()
    {
        //coger la parte con índice 3 del array para el método
        $this->method = empty($this->uri[3]) ? DEFAULT_METHOD : $this->uri[3];
    }

    public function setParams()
    {
        //cogemos los parámetros (uno o varios) que puedan existir
        for ($i = 4; $i < count($this->uri); $i++) {
            $this->params[] = !isset($this->uri[$i]) ? "" : $this->uri[$i];
        }
    }

    /// MÉTODOS GETTERS //
    public function getUri()
    {
        return $this->uri;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMethod()
    {
        return $this->method;
    }
    public function getParams()
    {
        return $this->params;
    }
}
