<?php

namespace Mhosts\Command\Hosts;

use Mhosts\Manager\HostsManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AddCommand extends Command
{
    const DEFAULT_IP_ADDRESS = '127.0.0.1';
    
    protected function configure()
    {
        $this
            ->setName('hosts:add')
            ->setDescription('Add another entry to your hosts file')
            ->addArgument('hostname', InputArgument::REQUIRED, 'The hostname to add to your hosts file.')
            ->addArgument('ipaddress', InputArgument::OPTIONAL, 'The IP Address to map hostname to', self::DEFAULT_IP_ADDRESS)
            ->addOption('path', 'p', InputOption::VALUE_OPTIONAL, 'The path to your hosts file', $this->getDefaultHostsLocation());
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!is_writable($path = $input->getOption('path'))) {
            return $output->writeln("<error>$path is not writable</error>");
        }
        
        $manager = new HostsManager($path);
        $manager->add($input->getArgument('hostname'), $input->getArgument('ipaddress'));
    }
    
    protected function getDefaultHostsLocation()
    {
        return '/etc/hosts';
    }
}