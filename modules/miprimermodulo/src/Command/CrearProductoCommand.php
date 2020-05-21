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
        //GET productos de otro Presta
        
        // try
        // {
            $webService = new PrestaShopWebservice('http://localhost/mitiendanueva/', 'K84GDDGVJPRI7M6IKYPLKCJ1W6BQCTEM', false);
            
            // Here we set the option array for the Webservice : we want products resources
            $opt = [
                'resource' => 'products',
                'filter[id]'  => '[20|21]'
            ];
            //dump($opt);
            // Call
            $xml = $webService->get($opt);
            // dump('xml');
            // dump($xml);
            // Here we get the elements from children of customers markup "products"
            $resources = $xml->products->children();
            // dump('resources');
            // dump($resources);

            //$apiKey = `K84GDDGVJPRI7M6IKYPLKCJ1W6BQCTEM`;
            $authorizationKey = base64_encode('K84GDDGVJPRI7M6IKYPLKCJ1W6BQCTEM'); // K84GDDGVJPRI7M6IKYPLKCJ1W6BQCTEM
            // dump('keyyyy');
            // dump($authorizationKey);
            foreach ($resources as $resource) {
                //$webServiceId = new PrestaShopWebservice('http://localhost/mitiendanueva/products/'.$resourceId, 'LZG9E7EVJ6FS1E7TCVAVCESCMXZMHC3X', false);
                // dump('resource');
                // dump($resource);
                $attributes = $resource->attributes();
                // dump('attributes');
                // dump($attributes);
                $resourceId = ((int)$attributes['id']);
                // dump('resourceId');
                // dump($resourceId);

                //$webService = new PrestaShopWebservice('http://localhost/mitiendanueva/', 'K84GDDGVJPRI7M6IKYPLKCJ1W6BQCTEM', false);
                $webServiceId = new PrestaShopWebservice('http://localhost/mitiendanueva/', 'K84GDDGVJPRI7M6IKYPLKCJ1W6BQCTEM', false);
                //$webServiceId = new PrestaShopWebservice('http://localhost/mitiendanueva/products/', 'LZG9E7EVJ6FS1E7TCVAVCESCMXZMHC3X', false);

                $optId = [
                    'resource' => 'products',
                    'id'  => $resourceId
                ];
                // dump('optId');
                // dump($optId);

                $xmlId = $webServiceId->get($optId);
                // dump('xmlId');
                // dump($xmlId);

                $resourcesId = $xmlId->product->children();
                // dump('resourcesId');
                // dump($resourcesId);
                // $nombre = $resourcesId->name->language[0];
                // dump('nombre de producto');
                // dump($nombre);
                // $sgProduct = new Product(1);
                $nlProduct = new Product(); // Remove ID later
                    $nlProduct->id_category_default = $resourcesId->id_category_default;
                    dump('categoria por defecto');
                    dump($nlProduct->id_category_default);
                    $nlProduct->id_category=$nlProduct->id_category_default;
                    dump('categoria id');
                    dump($nlProduct->id_category);
                    $nlProduct->new;
                    $nlProduct->type = $resourcesId->type;
                    dump('type');
                    dump($nlProduct->type);
                    $nlProduct->reference = $resourcesId->reference;
                    $nlProduct->weight =  $resourcesId->weight;
                    // $nlProduct->price = ceil($input->getArgument('precio'));
                    $nlProduct->price = $resourcesId->price;
                    //$output->writeln('Precio: '.$nlProduct->price);
                    $nlProduct->wholesale_price = $resourcesId->wholesale_price;
                    $nlProduct->active = $resourcesId->active;
                    $nlProduct->available_for_order = $resourcesId->available_for_order;
                    $nlProduct->show_price = $resourcesId->show_price;
                    $languages = Language::getLanguages();
                    foreach($languages as $lang){
                        
                        //  $nlProduct->name[$lang['id_lang']] = $sgProduct->name->language;
                        //  $nlProduct->description[$lang['id_lang']] = $sgProduct->description->language;
                        $nlProduct->name[$lang['id_lang']] = $resourcesId->name->language[0];
                        //$output->writeln('Hello Word! Nombre Language '.$lang['name'].' es: '.$nlProduct->name[$lang['id_lang']].' ');
                        $nlProduct->description[$lang['id_lang']] = $resourcesId->description->language[0];
                        //$output->writeln('Hello Word! Description Language '.$lang['name'].' es: '.$nlProduct->description[$lang['id_lang']].' ');
                    }
                    // echo($sgProduct->name->language);
                    $nlProduct->add();

                
                // }
                //$url = 'http://LZG9E7EVJ6FS1E7TCVAVCESCMXZMHC3X@localhost/mitiendanueva/api/products/'.$resourceId;
                 //$url = 'http://'.$authorizationKey.'@localhost/mitiendanueva/api/products/'.$resourceId;
                 //dump($url);
                // dump('url');
                // dump($url);
                // From there you could, for example, use th resource ID to call the webservice to get its details
            }
            //dump($resources);
        //}
        // catch (PrestaShopWebserviceException $e)
        // {
        //     // // Here we are dealing with errors
        //     // $trace = $e->getTrace();
        //     // if ($trace[0]['args'][0] == 404) echo 'Bad ID';
        //     // else if ($trace[0]['args'][0] == 401) echo 'Bad auth key';
        //     // else echo 'Other error';
        // }



        //FIN GET productos de otro Presta

        //Crear Productos

        // $sgProduct = new Product(1);
        // $nlProduct = new Product(); // Remove ID later
        //     $nlProduct->id_category_default = 2;
        //     $nlProduct->id_category[]=$nlProduct->id_category_default;
        //     $nlProduct->new;
        //     $nlProduct->type = "simple";
        //     $nlProduct->reference = $sgProduct->reference;
        //     $nlProduct->weight =  $sgProduct->weight;
        //     // $nlProduct->price = ceil($input->getArgument('precio'));
        //     $nlProduct->price = $input->getArgument('precio');
        //     $output->writeln('Precio: '.$nlProduct->price);
        //     $nlProduct->wholesale_price = $sgProduct->wholesale_price;
        //     $nlProduct->active = 0;
        //     $nlProduct->available_for_order = 1;
        //     $nlProduct->show_price = 1;
        //     $languages = Language::getLanguages();
        //     foreach($languages as $lang){
        //         //  $nlProduct->name[$lang['id_lang']] = $sgProduct->name->language;
        //         //  $nlProduct->description[$lang['id_lang']] = $sgProduct->description->language;
        //         $nlProduct->name[$lang['id_lang']] = $input->getArgument('name');
        //         $output->writeln('Hello Word! Nombre Language '.$lang['name'].' es: '.$nlProduct->name[$lang['id_lang']].' ');
        //         $nlProduct->description[$lang['id_lang']] = $input->getArgument('description');
        //         $output->writeln('Hello Word! Description Language '.$lang['name'].' es: '.$nlProduct->description[$lang['id_lang']].' ');
        //     }
        //     // echo($sgProduct->name->language);
        //     $nlProduct->add();
        //     //$nlProduct->update();

         // FinCrear Productos


        $output->writeln('Hello Word! id_Product es: '.$nlProduct->id.' ');
        //  $output->writeln('Hello Word! id_Product es: '.$nlProduct->name.' ');
        // $output->writeln('Hello Word! id_Product es: '.$nlProduct->name.' ');
        // $output->writeln('Nombre: '.$nlProduct.' ');
        //$output->writeln('Categoría: '.$nlProduct->id_category.' ');
    }
}