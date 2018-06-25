<?php

namespace AppBundle\Traits;

use Gedmo\Mapping\Annotation\Timestampable;

trait TimestampableEntity
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     * @Timestampable(on="create")
     */
    protected $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update_date", type="datetime", nullable=false)
     * @Timestampable(on="update")
     */
    protected $lastUpdateDate;

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Parent
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set lastUpdateDate
     *
     * @param \DateTime $lastUpdateDate
     * @return Project
     */
    public function setLastUpdateDate($lastUpdateDate)
    {
        $this->lastUpdateDate = $lastUpdateDate;

        return $this;
    }

    /**
     * Get lastUpdateDate
     *
     * @return \DateTime
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate;
    }
}
