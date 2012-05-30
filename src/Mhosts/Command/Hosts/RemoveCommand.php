<?php

namespace Mhosts\Command\Hosts;

use Mhosts\Manager\HostsManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('hosts:remove')
            ->setDescription('Remove an entry from your hosts file')
            ->addArgument('hostname', InputArgument::REQUIRED, 'The hostname to remove from your hosts file.')
            ->addOption('path', 'p', InputOption::VALUE_OPTIONAL, 'The path to your hosts file', $this->getDefaultHostsLocation());
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!is_writable($path = $input->getOption('path'))) {
            return $output->writeln("<error>$path is not writable</error>");
        }
        
        $manager = new HostsManager($path);
        $manager->remove($input->getArgument('hostname'));
    }
    
    protected function getDefaultHostsLocation()
    {
        return '/etc/hosts';
    }
}