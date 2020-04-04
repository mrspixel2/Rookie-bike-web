<?php

namespace EspaceClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="idRe", columns={"idRe"})})
 * @ORM\Entity
 */
class Reclamation
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
     * @ORM\Column(name="contenu", type="string", length=100, nullable=false)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=50, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;
    

    /**
     * @var \Recevent
     *
     * @ORM\ManyToOne(targetEntity="GeneralBundle\Entity\Recevent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRe", referencedColumnName="idR")
     * })
     */
    private $idre;

    
    /**
     * @ORM\ManyToOne(targetEntity="Produit")
     *
     * @ORM\JoinColumn(name="idvelo", referencedColumnName="idVelo")
     *
     */
    private $produit;

    /**
     * @return mixed
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param mixed $produit
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;
    }





    /**
     * Get the value of type
     *
     * @return  string
     */ 
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of contenu
     *
     * @return  string
     */ 
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set the value of contenu
     *
     * @param  string  $contenu
     *
     * @return  self
     */ 
    public function setContenu( $contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get the value of etat
     *
     * @return  string
     */ 
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set the value of etat
     *
     * @param  string  $etat
     *
     * @return  self
     */ 
    public function setEtat( $etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return  integer
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  integer  $id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}

