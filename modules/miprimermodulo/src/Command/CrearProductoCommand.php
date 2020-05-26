<?php
// mi_primer_modulo/src/Command/CrearProductoCommand.php
namespace Webimpacto\MiPrimerModulo\Command;
//require_once('./PSWebServiceLibrary.php');
require_once('C:/xampp/htdocs/mitienda/modules/miprimermodulo/src/PSWebServiceLibrary.php');

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Webimpacto\MiPrimerModulo\Command\PSWebServiceLibrary;
use Language;
use Product;
use Context;
use Configuration;
use Shop;
use Employee;
use FrontController;
use Category;
//use PrestaShop\Adapter\Shop\Context;


class CrearProductoCommand extends Command
{
    protected function configure()
    {
        // The name of the command (the part after "bin/console")
        $this->setName('miprimermodulo:create');
        // $this->addArgument('name', InputArgument::REQUIRED, '¿Escriba el nombre?');
        // $this->addArgument('description', InputArgument::REQUIRED, '¿Escriba la descripcion?');
        // $this->addArgument('precio', InputArgument::REQUIRED,'Escriba el precio');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $id_shop = $input->getOption('id_shop');
        
        $this->context = Context::getContext();
        if(!$id_shop){
            $id_shop = Configuration::get('PS_SHOP_DEFAULT');
            Shop::setContext(Shop::CONTEXT_ALL, $id_shop);
        }
        $this->context->employee = new Employee(1);
        $this->context->controller = new FrontController();
        //GET productos de otro Presta

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

                
                $productos = new Product();
                $arrayProductos =$productos->getProducts(1,0,0,'id_product','asc',false,false,null);
                
                $veces_igual= 0;
                        foreach($arrayProductos as $productoArray){
                                if($productImport['reference'] == $productoArray['reference']){
                                    $veces_igual++; 
                                }
                                //$veces++;
                            //}
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

                    //dump($responseCategory);
                    curl_close($curlCategory);
                    $arrayCategory = json_decode($responseCategory,true);
                    //dump($arrayCategory['category']);
                    $categoryImport =$arrayCategory['category'];

                    $categoriaJSON = new Category(null,1,1); // Remove ID later
                    //dump($categoriaJSON);
                    
                    $categoriaJSON->id_category_import = $categoryImport['id'];
                    //  //dump($productJSON->id_category_default);
                    $categoriaJSON->id_category=$categoriaJSON->id;
                    $categoriaJSON->name=$categoryImport['name'][0]['value'];
                    $categoriaJSON->id_parent=$categoryImport['id_parent'];
                    $categoriaJSON->level_depth=$categoryImport['level_depth'];
                    $categoriaJSON->link_rewrite=$categoryImport['link_rewrite'][0]['value'];
                    $categoriaJSON->id_shop_default=$categoryImport['id_shop_default'];
                    $categoriaJSON->is_root_category=$categoryImport['is_root_category'];
                    $categoriaJSON->description=$categoryImport['description'][0]['value'];


                $categoriaJSON->add();
                $output->writeln('Hello Word! id_category es: '.$categoriaJSON->id_category_import.' ');

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



                $productJSON->add();
                $output->writeln('Hello Word! id_Product es: '.$productJSON->id.' ');
                } else{
                    // dump('Esta repetido');
                }                   
                
                
            }
        //dump($productJSON);      // Dump all data of the Object



         $output->writeln('Hello Word! Finalllllllll');
        //  $output->writeln('Hello Word! id_Product es: '.$nlProduct->name.' ');
        // $output->writeln('Hello Word! id_Product es: '.$nlProduct->name.' ');
        // $output->writeln('Nombre: '.$nlProduct.' ');
        //$output->writeln('Categoría: '.$nlProduct->id_category.' ');
    }
}