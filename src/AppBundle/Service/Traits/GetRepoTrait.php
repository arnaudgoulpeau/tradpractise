<?php

namespace AppBundle\Service\Traits;


trait GetRepoTrait
{
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

        return $this->entityManager->getRepository(sprintf('%s:%s', $bundlename, $entityName));
    }
}