<?php

namespace AppBundle\Service;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager;

/**
 * BaseService
 */
abstract class AbstractBaseService
{
    /**
     * Doctrine Entity Manager
     * @var EntityManager
     */
    protected $em;

    /**
     * Translation service
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * Validation service
     * @var ValidatorInteface
     */
    protected $validator;

    /**
     * Security service (to retrieve user, check roles, etc.)
     * @var SecurityContext
     */
    protected $securityContext;

    /**
     * logger service
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Application roles
     * @var array
     */
    protected $hierarchyRoles;

    /**
     * tune files path
     * @var string
     */
    protected $tuneFilesPath;

    /**
     * root path
     * @var string
     */
    protected $rootPath;

    /**
     * Constructor
     * @param EntityManager       $em
     * @param SecurityContext     $securityContext
     * @param TranslatorInterface $translator
     * @param ValidatorInterface  $validator
     * @param array               $hierarchyRoles
     * @param string              $rootPath
     * @param string              $tuneFilesPath
     */
    public function __construct(
        EntityManager $em,
        SecurityContextInterface $securityContext,
        TranslatorInterface $translator,
        ValidatorInterface $validator,
        array $hierarchyRoles,
        $rootPath,
        $tuneFilesPath
    ) {
        $this->em = $em;
        $this->securityContext = $securityContext;
        $this->translator = $translator;
        $this->validator = $validator;
        $this->hierarchyRoles = $hierarchyRoles;
        $this->rootPath = $rootPath;
        $this->tuneFilesPath = $tuneFilesPath;
    }

    /**
     * Returns an element for a given ID
     * @param string $entityName
     * @param string $alias
     * @param int    $id
     * @return object
     */
    public function getOneById($entityName, $alias, $id)
    {
        try {
            $q = $this->getBaseQuery($entityName, $alias)
                     ->where(sprintf('%s.id = :id', $alias))
                     ->setParameter('id', $id);

            return $q->select($alias)->getQuery()->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * flush
     */
    public function flush()
    {
        $this->em->flush();
    }

    /**
     * Deletes the entity from the DB
     * @param Entity $entity
     */
    public function delete($entity)
    {
        // Delete from DB
        $this->em->remove($entity);
        $this->em->flush();

    }

    /**
     * Returns entity repository
     * @param string $entityName
     * @param string $bundlename
     * @return EntityRepository
     */
    protected function getRepo($entityName, $bundlename = "")
    {

        if ($bundlename == "") {
            $bundlename = "AppBundle";
        }

        return $this->em->getRepository(sprintf('%s:%s', $bundlename, $entityName));
    }

    /**
     * Returns base query for the given entity
     * @param string $entityName
     * @param string $alias
     * @param string $bundlename
     * @return QueryBuilder
     */
    protected function getBaseQuery($entityName, $alias, $bundlename = "")
    {
        if ($bundlename == "") {
            $bundlename = "AppBundle";
        }

        return $this->em->createQueryBuilder()->from(sprintf('%s:%s', $bundlename, $entityName), $alias);
    }
}
