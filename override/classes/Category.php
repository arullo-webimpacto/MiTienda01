<?php
Class Category extends CategoryCore{
    public $id_category_import;

    public function __construct($idCategory = null, $idLang = null, $idShop = null){
        // exit('Hola estoy en catefgory mdfsdsdfsdffs');
        self::$definition['fields']['id_category_import'] = array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt');
        parent::__construct($idCategory, $idLang, $idShop);
        
    }
}