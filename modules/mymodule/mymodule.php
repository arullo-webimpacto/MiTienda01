<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class MyModule extends Module
{

    public function __construct(){
        $this->name = 'mymodule'; //nombre del módulo el mismo que la carpeta y la clase.
        $this->tab = 'others'; // pestaña en la que se encuentra en el backoffice.
        $this->version = '1.0.0'; //versión del módulo
        $this->author ='Abraham Rullo'; // autor del módulo
        $this->need_instance = 0; //si no necesita cargar la clase en la página módulos,1 si fuese necesario.
        $this->ps_versions_compliancy = array('min' => '1.7.x.x', 'max' => _PS_VERSION_); //las versiones con las que el módulo es compatible.
        $this->bootstrap = true; //si usa bootstrap plantilla responsive.

        parent::__construct(); //llamada al constructor padre.

        $this->displayName = $this->l('mymodule'); // Nombre del módulo
        $this->description = $this->l('Módulo de prueba.'); //Descripción del módulo
        $this->confirmUninstall = $this->l('¿Estás seguro de que quieres desinstalar el módulo?'); //mensaje de alerta al desinstalar el módulo.

        
    }
}