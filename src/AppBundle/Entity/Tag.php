<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return TuneFileType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add tunes
     *
     * @param \AppBundle\Entity\Tune $tune
     * @return Tag
     */
    public function addTune(\AppBundle\Entity\Tune $tune)
    {
        $this->tunes[] = $tune;

        return $this;
    }

    /**
     * Remove tune
     *
     * @param \AppBundle\Entity\Tune $tune
     */
    public function removeTune(\AppBundle\Entity\Tune $tune)
    {
        $this->tunes->removeElement($tune);
    }

    /**
     * Get tunes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTunes()
    {
        return $this->tunes;
    }

    /**
     *
     * @return type
     */
    public function __toString()
    {
        return $this->name;
    }
}
