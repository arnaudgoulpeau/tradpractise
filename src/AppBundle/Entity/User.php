<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     *
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     *
     */
    protected $prenom;

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
        $this->setLocked(false);
        $this->setEnabled(true);
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @Assert\NotBlank()
     * @return string
     */
    public function getUsername()
    {
        return parent::getUsername();
    }

    /**
     * @Assert\NotBlank()
     * @return string
     */
    public function getEmail()
    {
        return parent::getEmail();
    }

     /**
     * Validate the password
     *
     * @Assert\IsTrue(message="User.validation.password.not_blank")
     * @return boolean
     */
    public function isPlainPasswordSet()
    {
        $isPlainPasswordSet = true;
        if ($this->getId() === null) {
            //creation
            $plainPassword = $this->getPlainPassword();
            if ($plainPassword === '' || $plainPassword === null) {
                $isPlainPasswordSet =  false;
            }
        }

        return $isPlainPasswordSet;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Init salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }
}
