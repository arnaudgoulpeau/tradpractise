<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PractiseSessionRepository")
 */
class PractiseSession
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\ManyToMany(targetEntity="TuneSet", inversedBy="practiseSessions")
     *
     */
    private $tuneSets;

    /**
     * @ORM\ManyToMany(targetEntity="Technique", inversedBy="practiseSessions")
     */
    private $techniques;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Tune")
     * @ORM\JoinColumn(name="warmup_tune_id", referencedColumnName="id", nullable=false)
     */
    private $warmupTune;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tuneSets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->techniques = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return PractiseSession
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
     * Set notes
     *
     * @param string $notes
     * @return PractiseSession
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Add tuneSets
     *
     * @param \AppBundle\Entity\TuneSet $tuneSets
     * @return PractiseSession
     */
    public function addTuneSet(\AppBundle\Entity\TuneSet $tuneSets)
    {
        $this->tuneSets[] = $tuneSets;

        return $this;
    }

    /**
     * Remove tuneSets
     *
     * @param \AppBundle\Entity\TuneSet $tuneSets
     */
    public function removeTuneSet(\AppBundle\Entity\TuneSet $tuneSets)
    {
        $this->tuneSets->removeElement($tuneSets);
    }

    /**
     * Get tuneSets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTuneSets()
    {
        return $this->tuneSets;
    }

    /**
     * Add techniques
     *
     * @param \AppBundle\Entity\Technique $techniques
     * @return PractiseSession
     */
    public function addTechnique(\AppBundle\Entity\Technique $techniques)
    {
        $this->techniques[] = $techniques;

        return $this;
    }

    /**
     * Remove techniques
     *
     * @param \AppBundle\Entity\Technique $techniques
     */
    public function removeTechnique(\AppBundle\Entity\Technique $techniques)
    {
        $this->techniques->removeElement($techniques);
    }

    /**
     * Get techniques
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTechniques()
    {
        return $this->techniques;
    }

    /**
     * Set warmupTune
     *
     * @param \AppBundle\Entity\Tune $warmupTune
     * @return PractiseSession
     */
    public function setWarmupTune(\AppBundle\Entity\Tune $warmupTune)
    {
        $this->warmupTune = $warmupTune;

        return $this;
    }

    /**
     * Get warmupTune
     *
     * @return \AppBundle\Entity\Tune
     */
    public function getWarmupTune()
    {
        return $this->warmupTune;
    }

    public function __toString()
    {
        return $this->name;
    }
}
