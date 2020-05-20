<?php
// mi_primer_modulo/src/Command/CrearProductoCommand.php
namespace Webimpacto\MiPrimerModulo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Language;
use Product;

class CrearProductoCommand extends Command
{
    protected function configure()
    {
        // The name of the command (the part after "bin/console")
        $this->setName('miprimermodulo:create');
        $this->addArgument('name', InputArgument::REQUIRED, '¿Escriba el nombre?');
        $this->addArgument('description', InputArgument::REQUIRED, '¿Escriba la descripcion?');
        $this->addArgument('precio', InputArgument::REQUIRED,'Escriba el precio');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$id_product = $input->getArgument('idproduct');

        $sgProduct = new Product(1);
        $nlProduct = new Product(); // Remove ID later
            $nlProduct->id_category_default = 2;
            $nlProduct->id_category[]=$nlProduct->id_category_default;
            $nlProduct->new;
            $nlProduct->type = "simple";
            $nlProduct->reference = $sgProduct->reference;
            $nlProduct->weight =  $sgProduct->weight;
            // $nlProduct->price = ceil($input->getArgument('precio'));
            $nlProduct->price = $input->getArgument('precio');
            $output->writeln('Precio: '.$nlProduct->price);
            $nlProduct->wholesale_price = $sgProduct->wholesale_price;
            $nlProduct->active = 0;
            $nlProduct->available_for_order = 1;
            $nlProduct->show_price = 1;
            $languages = Language::getLanguages();
            foreach($languages as $lang){
                //  $nlProduct->name[$lang['id_lang']] = $sgProduct->name->language;
                //  $nlProduct->description[$lang['id_lang']] = $sgProduct->description->language;
                $nlProduct->name[$lang['id_lang']] = $input->getArgument('name');
                $output->writeln('Hello Word! Nombre Language '.$lang['name'].' es: '.$nlProduct->name[$lang['id_lang']].' ');
                $nlProduct->description[$lang['id_lang']] = $input->getArgument('description');
                $output->writeln('Hello Word! Description Language '.$lang['name'].' es: '.$nlProduct->description[$lang['id_lang']].' ');
            }
            // echo($sgProduct->name->language);
            $nlProduct->add();
            //$nlProduct->update();
        
        $output->writeln('Hello Word! id_Product es: '.$nlProduct->id.' ');
        //  $output->writeln('Hello Word! id_Product es: '.$nlProduct->name.' ');
        // $output->writeln('Hello Word! id_Product es: '.$nlProduct->name.' ');
        // $output->writeln('Nombre: '.$nlProduct.' ');
        //$output->writeln('Categoría: '.$nlProduct->id_category.' ');
    }
}