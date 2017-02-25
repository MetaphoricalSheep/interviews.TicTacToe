<?php
/**
 * Doctrine 2.4 bootstrap
 *
 */

use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
    Doctrine\Common\Cache\ArrayCache;

class Doctrine {

    private $_em = null;

    public function __construct()
    {
        // Load database configuration from CodeIgniter
        require_once APPPATH.'vendor/autoload.php';
        require_once APPPATH.'config/database.php';

        // load the Doctrine classes
        $doctrineClassLoader = new ClassLoader('Doctrine',  APPPATH.'vendor/doctrine');
        $doctrineClassLoader->register();
        // load the entities
        $entityClassLoader = new ClassLoader('models', APPPATH.'models/Entities');
        $entityClassLoader->register();
        // load the proxy entities
        $proxiesClassLoader = new ClassLoader('Proxies', APPPATH.'models/proxies');
        $proxiesClassLoader->register();
        // load Symfony2 classes
        // this is necessary for YAML mapping files and for Command Line Interface (cli-doctrine.php)
        $symfonyClassLoader = new ClassLoader('Symfony',  APPPATH.'vendor/symfony');
        $symfonyClassLoader->register();

        // Set up the configuration
        $config = new Configuration;
        $cache = new ArrayCache;
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver(array(APPPATH.'models/Entities'));
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);

        $config->setQueryCacheImpl($cache);

        // Proxy configuration
        $config->setProxyDir(APPPATH.'/models/proxies');
        $config->setProxyNamespace('Proxies');

        // Set up logger
        $logger = new Doctrine\DBAL\Logging\DebugStack();
        $config->setSQLLogger($logger);

        $config->setAutoGenerateProxyClasses( TRUE );

        \Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');

        // Database connection information
        $connectionOptions = array(
            'driver' => 'pdo_mysql',
            'user' =>     $db['default']['username'],
            'password' => $db['default']['password'],
            'host' =>     $db['default']['hostname'],
            'dbname' =>   $db['default']['database']
        );

        // Create EntityManager
        $this->_em = EntityManager::create($connectionOptions, $config);
    }

    /**
     * @return EntityManager
     */
    public function GetEntityManager() : EntityManager
    {
        return $this->_em;
    }
}