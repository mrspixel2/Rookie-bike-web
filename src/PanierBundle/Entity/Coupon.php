<?php

namespace PanierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coupon
 *
 * @ORM\Table(name="coupon")
 * @ORM\Entity(repositoryClass="PanierBundle\Repository\CouponRepository")
 */
class Coupon
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="coupon", type="string", length=255, unique=true)
     */
    private $coupon;

    /**
     * @var string
     *
     * @ORM\Column(name="disc", type="string", length=255)
     */
    private $disc;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set coupon
     *
     * @param string $coupon
     *
     * @return Coupon
     */
    public function setCoupon($coupon)
    {
        $this->coupon = $coupon;

        return $this;
    }

    /**
     * Get coupon
     *
     * @return integer
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * Set disc
     *
     * @param string $disc
     *
     * @return Coupon
     */
    public function setDisc($disc)
    {
        $this->disc = $disc;

        return $this;
    }

    /**
     * Get disc
     *
     * @return string
     */
    public function getDisc()
    {
        return $this->disc;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Coupon
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }
}

