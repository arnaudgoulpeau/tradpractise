<?php

namespace AppBundle\Repository;

use AppBundle\Entity\TuneFileType;
use Doctrine\ORM\EntityRepository;

/**
 * TuneFileRepository
 */
class TuneFileRepository extends EntityRepository
{
    /**
     * @param bool $includeSlow
     * @return array
     */
    public function getAllMp3($includeSlow = true)
    {
        $qb = $this->createQueryBuilder('tf');

        $qb->andWhere("tf.tuneFileType = :mp3")
            ->setParameter('mp3', TuneFileType::TUNE_FILE_TYPE_MP3_ID);

        return $qb
                ->orderBy('tf.name', 'ASC')
                ->getQuery()->getResult();

    }
}
