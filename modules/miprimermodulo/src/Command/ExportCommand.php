<?php
namespace mitienda\miprimermodulo\src\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportCommand extends Command
{
    protected function configure()
    {
        // The name of the command (the part after "bin/console")
        $this->setName('miprimermodulo:export');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Here your business logic.
        $output->write('Hello Word!');
    }
}