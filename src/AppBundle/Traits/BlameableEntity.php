<?php

namespace AppBundle\Traits;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;

/**
 * BlameableEntity Trait
 */
trait BlameableEntity
{
    /**
     * @var object $creationUser
     *
     * @ORM\Column(name="creation_user", type="string", length=255, nullable=false)
     * @Assert\NotNull()
     */
    protected $creationUser;

    /**
     * @var object $lastUpdateUser
     *
     * @ORM\Column(name="last_update_user", type="string", length=255, nullable=false)
     * @Assert\NotNull()
     */
    protected $lastUpdateUser;
	
    /**
     * Set creationUser
     *
     * @param string $creationUser
     * @return TraceableEntity
     */
    public function setCreationUser($creationUser)
    {
        $this->creationUser = $creationUser;
    
        return $this;
    }

    /**
     * Get creationUser
     *
     * @return string 
     */
    public function getCreationUser()
    {
        return $this->creationUser;
    }

    /**
     * Set lastUpdateUser
     *
     * @param string $lastUpdateUser
     * @return TraceableEntity
     */
    public function setLastUpdateUser($lastUpdateUser)
    {
        $this->lastUpdateUser = $lastUpdateUser;
    
        return $this;
    }

    /**
     * Get lastUpdateUser
     *
     * @return string 
     */
    public function getLastUpdateUser()
    {
        return $this->lastUpdateUser;
    }
}
