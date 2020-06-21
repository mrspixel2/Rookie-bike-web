<?php

namespace LocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pointlocation
 *
 * @ORM\Table(name="pointlocation")
 * @ORM\Entity
 */
class Pointlocation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_point", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPoint;

    /**
     * @var string
     *
     * @ORM\Column(name="Region", type="string", length=255, nullable=false)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="langitude", type="string", length=255, nullable=false)
     */
    private $langitude;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255, nullable=false)
     */
    private $latitude;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->idPoint;
    }

    /**
     * @param int $idPoint
     */
    public function setId($idPoint)
    {
        $this->idPoint = $idPoint;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getLangitude()
    {
        return $this->langitude;
    }

    /**
     * @param string $langitude
     */
    public function setLangitude($langitude)
    {
        $this->langitude = $langitude;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }


}

