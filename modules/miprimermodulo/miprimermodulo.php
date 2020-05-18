<?php
/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

//use PrestaShop\PrestaShop\Core\Module\WidgetInterface;



class Miprimermodulo extends Module
{
    /** @var Product */
    protected $product;

    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'miprimermodulo';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Abraham Rullo de las Heras';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('My primer modulo');
        $this->description = $this->l('My primer modulo,My primer modulo');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        // Configuration::updateValue('MODULO_ABRAHAM_TEXTO_HOME', false);

        if (!parent::install() ||
            !$this->registerHook('displayHome') ||
            !$this->registerHook('displayFooterProduct')
        ) {
            return false;
        }

        return true;

        // return parent::install() &&
        //     $this->registerHook('displayHome') &&
        //     $this->registerHook('displayFooterProduct');


    }

    public function uninstall()
    {

        if (!parent::uninstall() ||
            !$this->unregisterHook('displayHome') ||
            !$this->unregisterHook('displayFooterProduct')
        ) {
            return false;
        }

        return true;
        // if( !parent::uninstall() || !$this->unregisterHook('displayHome'))
        //     return false;
        // return true;
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        return $this->postProcess() . $this->getForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    public function getForm()
    {
        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->languages = $this->context->controller->getLanguages();
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = $this->context->controller->default_form_language;
        $helper->allow_employee_form_lang = $this->context->controller->allow_employee_form_lang;
        $helper->title = $this->displayName;

        $helper->submit_action = 'miprimermodulo';
        $helper->fields_value['texto'] = Configuration::get('MODULO_ABRAHAM_TEXTO_HOME');
        
        $this->form[0] = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->displayName
                 ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Texto'),
                        'desc' => $this->l('Qué texto quieres que aparezca en la página de inicio'),
                        'hint' => $this->l('Pista'),
                        'name' => 'texto',
                        'lang' => false,
                     ),
                 ),
                'submit' => array(
                    'title' => $this->l('Save')
                 )
             )
         );
        return $helper->generateForm($this->form);
    }



    public function postProcess()
    {
        if (Tools::isSubmit('miprimermodulo')) {
            $texto = Tools::getValue('texto');
            Configuration::updateValue('MODULO_ABRAHAM_TEXTO_HOME', $texto);
            return $this->displayConfirmation($this->l('Updated Successfully'));
        }
    }

    public function hookDisplayHome(array $params)
    {
        $texto = Configuration::get('MODULO_ABRAHAM_TEXTO_HOME');
        $this->context->smarty->assign(array('texto_variable' => $texto,));
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
        return $this->context->smarty->fetch($this->local_path.'views/templates/hook/home.tpl');
    }

    public function buscar(){
        if(isset($_GET["id"])){
            $id=(int)$_GET["id"];
             
            $usuario=new Usuario();
            $usuario->deleteById($id);
        }
        $this->redirect();
    }


    public function hookDisplayFooterProduct(array $params)
    {
        $texto = Configuration::get('MODULO_ABRAHAM_TEXTO_HOME');
        $this->context->smarty->assign(array('texto_variable' => $texto,));
        //Limpieza de codigo.Metiendo directamente el producto
        // $productt = $params['product']['name'];
        // $this->context->smarty->assign(array('productt' => $productt,));
        // $categoria_id = $params['product']['id_category_default'];
        // $this->context->smarty->assign(array('categoria_id' => $categoria_id,));
        // $categoria_name = $params['product']['category_name'];
        // $this->context->smarty->assign(array('categoria_name' => $categoria_name,));
        //$imagenes2 = new Product($params['product']);

        $product =$params['product'];
        $this->context->smarty->assign(array('product' => $product,));
        // $id_image = $params['product']['cover']['id_image'];
        // $this->context->smarty->assign(array('id_image' => $id_image,));
        // $link_rewrite = $params['product']['link_rewrite'];
        // $this->context->smarty->assign(array('link_rewrite' => $link_rewrite,));
        // $medida = $params['product'];
        //dump($product);
        //$this->context->smarty->assign(array('categoria_name' => $categoria_name,));
        //dump($categoria);
        //dump($params['product']['id_category_default']);
        
        
        //$products = $this->getSpecialProducts($params['product']);
        //$productt = Product::getAttributesParams($params);
        
        //$summary = $this->context->cart->getSummaryDetails();
        //Product::getProductCategoriesFull();
        //$this->context->smarty->assign('HOOK_FOOTER_PRODUCT',Hook::exec('displayFooterProduct'));
        // $producto = Product::getProductName(1);
        
        
        $this->context->controller->addCSS($this->_path.'/views/css/product.css');
        return $this->context->smarty->fetch($this->local_path.'views/templates/hook/product.tpl');
    }

    // public function hookBackOfficeHeader()
    // {
    //     if (Tools::getValue('module_name') == $this->name) {
    //         $this->context->controller->addJS($this->_path.'views/js/back.js');
    //         $this->context->controller->addCSS($this->_path.'views/css/back.css');
    //     }
    // }

    
    // public function rederWidget($hookName, array $configuration){

    //     $this->context->smarty->assign($this->getWidgetVariables($hookName,$configuration));

    //     if($hookName == 'displayLeftColumn' || $hookName == 'displayRigthColumn'){
    //         $template = 'column.tpl';
    //     }elseif($hookName == 'displayHome'){
    //         $template = 'column.tpl';
    //     }else(){
    //         $template = 'default.tpl';
    //     }
    //     return $this->fetch(templatePath: 'module:'.$this->name.'/views/templates/hook/'.$template);
    // }

    // public function getWidgetVariables($hookName, array $configuration){
        
    // }
}
