<?php

namespace PanierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255, nullable=false)
     */
    private $date;


    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=false)
     */
    private $montant;
      /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string",  length=255, nullable=true)
     */
    private $adress;

  /**
     * @var text
     *
     * @ORM\Column(name="qrcode", type="text" ,nullable=true)
     */
    private $qrcode;

   /**
     * @ORM\ManyToOne(targetEntity="GeneralBundle\Entity\User")
     *
     * @ORM\JoinColumn(name="userid", referencedColumnName="id")
     *
     */
    private $userid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="GeneralBundle\Entity\Produitbou", inversedBy="commande")
     * @ORM\JoinTable(name="commande_produit",
     *   joinColumns={
     *     @ORM\JoinColumn(name="commande_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="produit_id", referencedColumnName="id")
     *   }
     * )
     */
    private $produit;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->produit = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
 
    public function getQrcode()
    {
        return $this->qrcode;
    }


    public function setQrcode($date)
    {
        $this->qrcode = $date;
    }

    /**
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @param float $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduit()
    {
        return $this->produit;
    }
  /**
     * Add livraison
     *
     * @param \GeneralBundle\Entity\Produitbou $lignecmd
     *
     * @return lignecmd
     */
    public function addProduit( $lignecmd)
    {
        if (!$this->produit->contains($lignecmd)) {
            $this->produit[] = $lignecmd;
        }
       

        return $this;
    }



    /**
     * Get the value of adress
     *
     * @return  string
     */ 
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set the value of adress
     *
     * @param  string  $adress
     *
     * @return  self
     */ 
    public function setAdress( $adress)
    {
        $this->adress = $adress;

        return $this;
    }
}

