<?php
//require_once('./PSWebServiceLibrary.php');
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
require_once('C:/xampp/htdocs/mitienda/modules/miprimermodulo/src/PSWebServiceLibrary.php');
require 'vendor/autoload.php';

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

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "localhost/mitiendanueva/api/products?output_format=JSON",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic Szg0R0RER1ZKUFJJN002SUtZUExLQ0oxVzZCUUNURU06Oc ",
            "Cookie: PrestaShop-cbac049c40e842298a95cd1e70b00bde=def50200361ad098563fc2ae544f931676d4d44b5da873585c5ca6b0349e123fdf3330aede70df11b574eae14ae3c38561487679817d13b7095332c7f43c81a49c7f11f0cdd3987d220c3e3ee00c71ad4551c7cbc36e5fa962865788f32303de42f1323f5f103bc86407a0a0cc87b3e43a224e7333192e7028eb678a89f2183cf85b04832ae0b59162a344103517cae9dd7afb4b7135a942cf741fb3214f55429596"
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

            $array = json_decode($response,true);
            
            foreach($array['products'] as $productoArrayFuera){
                
                $curlId = curl_init();
                curl_setopt_array($curlId, array(
                    CURLOPT_URL => "localhost/mitiendanueva/api/products/".$productoArrayFuera["id"]."?output_format=JSON",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                      "Authorization: Basic Szg0R0RER1ZKUFJJN002SUtZUExLQ0oxVzZCUUNURU06Oc ",
                      "Cookie: PrestaShop-cbac049c40e842298a95cd1e70b00bde=def50200361ad098563fc2ae544f931676d4d44b5da873585c5ca6b0349e123fdf3330aede70df11b574eae14ae3c38561487679817d13b7095332c7f43c81a49c7f11f0cdd3987d220c3e3ee00c71ad4551c7cbc36e5fa962865788f32303de42f1323f5f103bc86407a0a0cc87b3e43a224e7333192e7028eb678a89f2183cf85b04832ae0b59162a344103517cae9dd7afb4b7135a942cf741fb3214f55429596"
                    ),
                  ));
                  $responseId = curl_exec($curlId);
                  
                  //dump($responseId);
                    curl_close($curlId);
                    $arrayId = json_decode($responseId,true);


                $productImport= $arrayId['product'];
               //dump($productImport);
                
                $productos = new Product();
                $arrayProductos =$productos->getProducts(1,0,0,'id_product','asc',false,false,null);
                $veces_igual= 0;
                        foreach($arrayProductos as $productoArray){
                            //dump($productoArray);
                                if($productImport['reference'] == $productoArray['reference']){
                                    $veces_igual++; 
                                }
                                //$veces++;
                            //}
                        }
                        

                        
                //$categoriaJSON->add();
                $asso=$productImport['associations']['images'];
                        foreach($asso as $imagen){
                            dump($imagen);
                           
                            $curlImagen = curl_init();
                        curl_setopt_array($curlImagen, array(
                            CURLOPT_URL => "localhost/mitiendanueva/api/images/".$imagen['id']."?output_format=JSON",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",
                            CURLOPT_HTTPHEADER => array(
                                "Authorization: Basic Szg0R0RER1ZKUFJJN002SUtZUExLQ0oxVzZCUUNURU06Oc ",
                                "Cookie: PrestaShop-cbac049c40e842298a95cd1e70b00bde=def50200361ad098563fc2ae544f931676d4d44b5da873585c5ca6b0349e123fdf3330aede70df11b574eae14ae3c38561487679817d13b7095332c7f43c81a49c7f11f0cdd3987d220c3e3ee00c71ad4551c7cbc36e5fa962865788f32303de42f1323f5f103bc86407a0a0cc87b3e43a224e7333192e7028eb678a89f2183cf85b04832ae0b59162a344103517cae9dd7afb4b7135a942cf741fb3214f55429596"
                            ),
                        ));
                        $responseImagen = curl_exec($curlImagen);
                        dump($responseImagen);
                        curl_close($curlImagen);
                            $arrayImagen = json_decode($responseImagen,true);
                        dump($arrayImagen);


                        }
                if($veces_igual==0){
//Crear categoria

                    $curlCategory = curl_init();
                        curl_setopt_array($curlCategory, array(
                            CURLOPT_URL => "localhost/mitiendanueva/api/categories/".$productImport["id_category_default"]."?output_format=JSON",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",
                            CURLOPT_HTTPHEADER => array(
                                "Authorization: Basic Szg0R0RER1ZKUFJJN002SUtZUExLQ0oxVzZCUUNURU06Oc ",
                                "Cookie: PrestaShop-cbac049c40e842298a95cd1e70b00bde=def50200361ad098563fc2ae544f931676d4d44b5da873585c5ca6b0349e123fdf3330aede70df11b574eae14ae3c38561487679817d13b7095332c7f43c81a49c7f11f0cdd3987d220c3e3ee00c71ad4551c7cbc36e5fa962865788f32303de42f1323f5f103bc86407a0a0cc87b3e43a224e7333192e7028eb678a89f2183cf85b04832ae0b59162a344103517cae9dd7afb4b7135a942cf741fb3214f55429596"
                            ),
                        ));
                        $responseCategory = curl_exec($curlCategory);

                        curl_close($curlCategory);
                            $arrayCategory = json_decode($responseCategory,true);
                            $categoryImport =$arrayCategory['category'];

                            $categoriaJSON = new Category(null,1,1); // Remove ID later
                            $categoriaJSON->id_category_import = $categoryImport['id'];
                            $categoriaJSON->id_category=$categoriaJSON->id;
                            $categoriaJSON->name=$categoryImport['name'][0]['value'];
                            $categoriaJSON->id_parent=$categoryImport['id_parent'];
                            $categoriaJSON->level_depth=$categoryImport['level_depth'];
                            $categoriaJSON->id_shop_default=$categoryImport['id_shop_default'];
                            $categoriaJSON->is_root_category=$categoryImport['is_root_category'];
                            $categoriaJSON->description=$categoryImport['description'][0]['value'];

 //Fin crear categoria
 //Crear categoria
                        $asso=$productImport['associations']['images'];
                        foreach($asso as $imagen){
                            
                        }
                        
                       

//Fin crear categoria

                    //dump('creamos');

                     //$pro= $array['product'];

                     $productJSON = new Product(); // Remove ID later
                         $productJSON->id_category_default = $productImport['id_category_default'];
                         //dump($productJSON->id_category_default);
                         $productJSON->id_category=$productImport['id_category_default'];
                         $productJSON->new;
                         $productJSON->type = $productImport['type'];
                         $productJSON->reference = $productImport['reference'];
                         $productJSON->weight =  $productImport['weight'];
                         $asso=$productImport['associations']['images'];
                            foreach($asso as $imagen){
                            
                            }
                         // $nlProduct->price = ceil($input->getArgument('precio'));
                         $productJSON->price = $productImport['price'];
                         //$output->writeln('Precio: '.$nlProduct->price);
                         $productJSON->wholesale_price = $productImport['wholesale_price'];
                         $productJSON->active = $productImport['active'];
                         $productJSON->available_for_order = $productImport['available_for_order'];
                         $productJSON->show_price = $productImport['show_price'];
                         $languages = Language::getLanguages();
                         foreach($languages as $lang){
                             //  $nlProduct->name[$lang['id_lang']] = $sgProduct->name->language;
                             //  $nlProduct->description[$lang['id_lang']] = $sgProduct->description->language;
                             $productJSON->name[$lang['id_lang']] = $productImport['name'][0]['value'];
                             //$output->writeln('Hello Word! Nombre Language '.$lang['name'].' es: '.$nlProduct->name[$lang['id_lang']].' ');
                             $productJSON->description[$lang['id_lang']] = $productImport['description'][0]['value'];
                             //$output->writeln('Hello Word! Description Language '.$lang['name'].' es: '.$nlProduct->description[$lang['id_lang']].' ');
                         }



                //$productJSON->add();
                //$output->writeln('Hello Word! id_Product es: '.$productJSON->id.' ');
                } else{
                    // dump('Esta repetido');
                }                   
                
                
            }




        
        

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
