<?php

namespace Mhosts\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends BaseApplication
{
    /**
     * {@inheritDoc}
     */
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $this->registerCommands();
        return parent::doRun($input, $output);
    }
    
    /**
     * {@inheritDoc}
     */
    protected function registerCommands()
    {
        $this->add(new \Mhosts\Command\Hosts\AddCommand());
        $this->add(new \Mhosts\Command\Hosts\RemoveCommand());
    }
}