<?php


namespace Crm_Getter\Classes\DbConnect;

use Crm_Getter\Interfaces\DbInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Psr\Log\LoggerInterface;

class DoctrineHandler implements DbInterface
{
    /**
     * @var EntityManager
     */
    public ?EntityManager $entityManager;

    /**
     * @var null | object
     */
    public ?object $model = null;

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

        $paths = array("/var/www/app/src");
        $dbParams = array(
            'driver' => 'pdo_mysql',
            'user' => DB_LOGIN,
            'password' => DB_PASS,
            'dbname' => DB_NAME,
            'host' => DB_HOST
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
        } catch (\Error $e) {
            $this->logger->error('Class = ' . __CLASS__ . '. Line = ' . __LINE__ . ' Error = ' . $e);
            die('ORM Error ' . $e);
        }
    }


}