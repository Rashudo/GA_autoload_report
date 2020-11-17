<?php

namespace Crm_Getter\Classes\DbConnect;

use Crm_Getter\Interfaces\DbInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Error;
use Exception;
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
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->createEntity();
    }

    private function createEntity()
    {
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
            $this->logger->error('Class = ' . __CLASS__
                . '. Line = ' . __LINE__
                . ' Error = ' . $e);
            die('No entityManager');
        }
    }

    public function saveData(object $object): void
    {
        try {
            if (!$this->entityManager->isOpen()) {
                $this->createEntity();
            }
            $this->entityManager->persist($object);
            $this->entityManager->flush();
        } catch (OptimisticLockException $e) {
            $this->logger->error('Class = ' . __CLASS__
                . '. Line = ' . __LINE__
                . ' OptimisticLockException = ' . $e->getMessage());
        } catch (ORMException $e) {
            $this->logger->error('Class = ' . __CLASS__
                . '. Line = ' . __LINE__
                . ' ORMException = ' . $e->getMessage());
        } catch (Error $e) {
            $this->logger->error('Class = ' . __CLASS__
                . '. Line = ' . __LINE__
                . ' Error = ' . $e->getMessage());
            die('ORM Error ' . $e);
        }
    }
}
