<?php

namespace LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Velo
 *
 * @ORM\Table(name="velo", indexes={@ORM\Index(name="point_relais_id", columns={"id_point"}), @ORM\Index(name="id_point", columns={"id_point"})})
 * @ORM\Entity
 */
class Velo
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
     * @ORM\Column(name="matricule", type="string", length=255, nullable=false)
     */
    private $matricule;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255, nullable=false)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="constructeur", type="string", length=255, nullable=false)
     */
    private $constructeur;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var \Pointlocation
     *
     * @ORM\ManyToOne(targetEntity="Pointlocation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_point", referencedColumnName="id_point")
     * })
     */
    private $idPoint;

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
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * @param string $matricule
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getConstructeur()
    {
        return $this->constructeur;
    }

    /**
     * @param string $constructeur
     */
    public function setConstructeur($constructeur)
    {
        $this->constructeur = $constructeur;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return \Pointlocation
     */
    public function getIdPoint()
    {
        return $this->idPoint;
    }

    /**
     * @param \Pointlocation $idPoint
     */
    public function setIdPoint($idPoint)
    {
        $this->idPoint = $idPoint;
    }
    


}

