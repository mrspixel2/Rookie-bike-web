<?php

namespace GeneralBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
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
     * @ORM\Column(name="login", type="string", length=50, nullable=true)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="pwd", type="string", length=255, nullable=true)
     */
    private $pwd;


    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=50, nullable=true)
     */
    private $lastname;
 /**
     * @var integer
     *
     * @ORM\Column(name="reclamation", type="integer",nullable=true)
     */
    private $reclamation;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=50, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=50, nullable=true)
     */
    private $role;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_panier", type="integer", nullable=true)
     */
    private $idPanier;
/**
     * @ORM\OneToMany(targetEntity="EspaceClientBundle\Entity\Produit", mappedBy="idClient")
     */
    private $produits;

/**
     * @ORM\OneToMany(targetEntity="PanierBundle\Entity\Commande", mappedBy="userid")
     */
    private $commandes;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->commandes = new ArrayCollection();

    }
    /**
     * @return Collection|produits[]
     */
    public function getProduits()
    {
        return $this->produits;
    }
    /**
     * @return Collection|commandes[]
     */
    public function getCommandes()
    {
        return $this->commandes;
    } 
    public function addCommandes( $lignecmd)
    {
        if (!$this->commandes->contains($lignecmd)) {
            $this->commandes[] = $lignecmd;
        }

        return $this;
    }
    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getReclamation()
    {
        return $this->reclamation;
    }

 
    public function setReclamation($login)
    {
        $this->reclamation = $login;
    }
    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     * @param string $pwd
     */
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }


}

