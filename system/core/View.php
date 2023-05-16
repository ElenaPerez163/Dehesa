<?php
class View
{
    ////  PROPIEDADES  ////
    protected $template;
    protected $vista;
    protected $params;

    ////  MÉTODOS  ////
    public function __construct($vista, $params = array())
    {
        $this->vista = $vista;
        $this->params = $params;
        $this->render(); //visualizar la vista
    }

    protected function render()
    {
        $this->template = $this->getContentTemplate($this->vista);
        echo $this->template;
    }

    protected function getContentTemplate($file)
    {
        $filePath = ROOT . PATH_VIEWS . $file . ".php";

        //si existe el fichero
        if (is_file($filePath)) {
            //extraer los parámetros del array de variables
            extract($this->params);

            //buffer
            ob_start(); //se inicia
            require $filePath; //mete la vista en el bufer
            $plantilla = ob_get_contents(); //obtiene el buffer
            ob_end_clean(); //finaliza y limpia el buffer
            return $plantilla;
        } else {
            throw new Exception("no existe la vista " . $filePath);
        }
    }
}
