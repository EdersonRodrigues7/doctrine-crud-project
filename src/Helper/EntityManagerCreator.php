<?php

namespace App\Helper;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\Middleware;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;

class EntityManagerCreator
{
    public static function createEntityManager(): EntityManager
    {
        // Create a simple "default" Doctrine ORM configuration for Attributes
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(__DIR__."/.."),
            isDevMode: true,
        );

        // Add logging to SQL statements
        $consoleOutput = new ConsoleOutput(ConsoleOutput::VERBOSITY_DEBUG);
        $consoleLogger = new ConsoleLogger($consoleOutput);
        $logMiddleware = new Middleware($consoleLogger);
        
        $config->setMiddlewares([
            $logMiddleware,
        ]);

        // Cache
        $cacheDirectory = __DIR__ . '/../../var/cache';

        // Metadata Cache
        $config->setMetadataCache(
            new PhpFilesAdapter(
                namespace: 'metadata_cache', 
                directory: $cacheDirectory
            )
        );

        // Query Cache
        $config->setQueryCache(
            new PhpFilesAdapter(
                namespace: 'query_cache',
                directory: $cacheDirectory
            )
        );

        // Result Cache
        // O ideal é usar um servidor externo (redis, memcache, algum serviço de nuvem)
        $config->setResultCache(
            new PhpFilesAdapter(
                namespace: 'result_cache',
                directory: $cacheDirectory
            )
        );

        // Database connection
        $connection = DriverManager::getConnection([
            'driver' => 'pdo_mysql',
            'host' => getenv('DATABASE_HOST'),
            'port' => getenv('DATABASE_PORT'),
            'dbname' => getenv('DATABASE_NAME'),
            'user' => getenv('DATABASE_USERNAME'),
            'password' => getenv('DATABASE_PASSWORD')
        ], $config);

        $entityManager = new EntityManager($connection, $config);

        return $entityManager;
    }
}