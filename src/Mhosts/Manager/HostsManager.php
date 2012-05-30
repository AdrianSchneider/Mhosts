<?php

namespace Mhosts\Manager;

class HostsManager
{
    /**
     * @var    string        Hosts file location
     */
    protected $path;
    
    /**
     * Sets the host file path
     * @param    string        Path to hosts file (ex: /etc/hosts)
     */
    public function __construct($path)
    {
        $this->path = $path;
    }
    
    /**
     * Add a new host/ip combination to the hosts file
     * @param    string        Hostname to add
     * @param    string        IP address to add
     */
    public function add($hostname, $ipaddress)
    {
        file_put_contents(
            $this->path, 
            file_get_contents($this->path) . 
                PHP_EOL . 
                sprintf('%s    %s', $ipaddress, $hostname) . 
                PHP_EOL
        );
    }
    
    /**
     * Remove a host from the hosts file
     * @param    string        Host name to remove
     */
    public function remove($hostname)
    {
        $newContents = array();
        foreach ($contents = file($this->path) as $line) {
            if (strpos($line, $hostname) === false) {
               $newContents[] = $line;
            }
        }
        
        file_put_contents(
            $this->path,
            implode('', $newContents)
        );
    }
    
    
    /**
     * Retrieve a list of all defined hosts in the hosts file
     * @return    array        Host names
     */
    public function getHosts()
    {
        $existing = array();
        foreach (file($this->path, \FILE_IGNORE_NEW_LINES | \FILE_SKIP_EMPTY_LINES) as $line) {
            if (strpos($line, '#') === 0) {
                continue;
            }
            
            
            list($ip, $host) = preg_split('/[\s,]+/', $line, 2, \PREG_SPLIT_NO_EMPTY);
            $existing[] = $host;
        }
        
        return $existing;
    }
}