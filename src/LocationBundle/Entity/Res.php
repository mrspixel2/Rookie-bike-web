<?php

namespace LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Res
 *
 * @ORM\Table(name="res", indexes={@ORM\Index(name="id_velo", columns={"id_velo"})})
 * @ORM\Entity
 */
class Res
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_reservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReservation;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="GeneralBundle\Entity\User");
    ")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idClient", referencedColumnName="id")
     * })
     */
    private $idClient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateRes", type="datetime", nullable=false)
     */
    private $dateres;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFin", type="datetime", nullable=false)
     */
    private $datefin;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixTot", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixtot;

    /**
     * @var float
     *
     * @ORM\Column(name="HeureLoca", type="float", precision=10, scale=0, nullable=false)
     */
    private $heureloca;

    /**
     * @var \Velo
     *
     * @ORM\ManyToOne(targetEntity="Velo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_velo", referencedColumnName="id")
     * })
     */
    private $idVelo;

    /**
     * @return \User
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * @param \User $idClient
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }

    /**
     * @return int
     */
    public function getIdReservation()
    {
        return $this->idReservation;
    }

    /**
     * @param int $idReservation
     */
    public function setIdReservation($idReservation)
    {
        $this->idReservation = $idReservation;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->idClient;
    }

    /**
     * @param int $idClient
     */
    public function setId($idClient)
    {
        $this->idClient = $idClient;
    }

    /**
     * @return \DateTime
     */
    public function getDateres()
    {
        return $this->dateres;
    }

    /**
     * @param \DateTime $dateres
     */
    public function setDateres($dateres)
    {
        $this->dateres = $dateres;
    }

    /**
     * @return \DateTime
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * @param \DateTime $datefin
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;
    }

    /**
     * @return float
     */
    public function getPrixtot()
    {
        return $this->prixtot;
    }

    /**
     * @param float $prixtot
     */
    public function setPrixtot($prixtot)
    {
        $this->prixtot = $prixtot;
    }

    /**
     * @return float
     */
    public function getHeureloca()
    {
        return $this->heureloca;
    }

    /**
     * @param float $heureloca
     */
    public function setHeureloca($heureloca)
    {
        $this->heureloca = $heureloca;
    }

    /**
     * @return \Velo
     */
    public function getIdVelo()
    {
        return $this->idVelo;
    }

    /**
     * @param \Velo $idVelo
     */
    public function setIdVelo($idVelo)
    {
        $this->idVelo = $idVelo;
    }


}

