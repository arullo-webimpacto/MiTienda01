<?php
Class Category extends CategoryCore{
    public $id_category_import;

    public function __construct($idCategory = null, $idLang = null, $idShop = null){
        parent::__construct($idCategory, $idLang, $idShop);
        self::$definition['fields']['id_category_import'] = array('type' => self::TYPE_INT, 'validate' => 'isGenericName', 'size' => 64);
    }
}