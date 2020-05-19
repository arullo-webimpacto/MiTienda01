<?php
// mi_primer_modulo/src/Command/ExportCommand.php
namespace Webimpacto\MiPrimerModulo\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Product;

class ExportCommand extends Command
{
    protected function configure()
    {
        // The name of the command (the part after "bin/console")
        $this->setName('miprimermodulo:export');
        $this->addArgument('idproduct', InputArgument::REQUIRED, '¿Escriba el id_Product?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id_product = $input->getArgument('idproduct');
        //$productt = 
        $product = new Product($id_product,false, 1, 1,null);
        // Here your business logic.
        
        $output->writeln('Hello Word! id_Product es: '.$id_product.' ');
        $output->writeln('Nombre: '.$product->name.' ');
        $output->writeln('Categoría: '.$product->category.' ');
    }
}