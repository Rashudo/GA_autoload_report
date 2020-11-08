<?php

namespace Crm_Getter\Classes\DbConnect;

use Crm_Getter\Classes\Logger\LogManager;
use Crm_Getter\Interfaces\DbInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Error;
use Psr\Log\LoggerInterface;

class DoctrineHandler implements DbInterface
{
    /**
     * @var EntityManager
     */
    public ?EntityManager $entityManager;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * DoctrineHandler constructor.
     * @param LoggerInterface $logger
     */
    public function __construct()
    {
        $this->logger = LogManager::getLogger();

        $paths = array("/var/www/app/src");
        $dbParams = array(
            'driver' => 'pdo_mysql',
            'user' => getenv('DB_LOGIN'),
            'password' => getenv('DB_PASS'),
            'dbname' => getenv('DB_NAME'),
            'host' => getenv('DB_HOST')
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, true);
        try {
            $this->entityManager = EntityManager::create($dbParams, $config);
        } catch (ORMException $e) {
            $this->logger->error('Class = ' . __CLASS__ . '. Line = ' . __LINE__ . ' Error = ' . $e);
            die('No entityManager');
        }
    }

    public function saveData(object $object): void
    {
        try {
            $this->entityManager->persist($object);
            $this->entityManager->flush();
        } catch (OptimisticLockException $e) {
            $this->logger->error('Class = ' . __CLASS__ . '. Line = ' . __LINE__ . ' Error = ' . $e);
        } catch (ORMException $e) {
            $this->logger->error('Class = ' . __CLASS__ . '. Line = ' . __LINE__ . ' Error = ' . $e);
        } catch (Error $e) {
            $this->logger->error('Class = ' . __CLASS__ . '. Line = ' . __LINE__ . ' Error = ' . $e);
            die('ORM Error ' . $e);
        }
        $this->logger->error('ERROR');
    }
}
