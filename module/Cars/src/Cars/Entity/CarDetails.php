<?php

namespace Cars\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * A single car
 *
 * @author jon
 *
 * @ORM\Entity
 * @ORM\Table(name="CarDetail")
 * @property string $transmissionType
 * @property string $license
 * @property date $purchased
 * @property integer $modelYear
 * @property decimal $engineSize
 * @property decimal $cost
 * @property string $image
 * @property string $bodyType
 * @property string $model
 * @property integer $id
 * @property string $make
 */
class CarDetails
{

    /**
     * @ORM\Column(type="string")
     *
     * @var unknown
     */
    protected $transmissionType;

    /**
     * @ORM\Column(type="string")
     *
     * @var unknown
     */
    protected $license;

    /**
     * @ORM\Column(type="date")
     *
     * @var unknown
     */
    protected $purchased;

    /**
     * @ORM\Column(type="integer")
     *
     * @var unknown
     */
    protected $modelYear;

    /**
     * @ORM\Column(type="decimal")
     *
     * @var unknown
     */
    protected $engineSize;

    /**
     * @ORM\Column(type="decimal")
     *
     * @var unknown
     */
    protected $cost;

    /**
     * @ORM\Column(type="string")
     *
     * @var unknown
     */
    protected $image;

    /**
     * @ORM\Column(type="string")
     *
     * @var unknown
     */
    protected $bodyType;

    /**
     * @ORM\Column(type="string")
     *
     * @var unknown
     */
    protected $model;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     *
     * @var unknown
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var unknown
     */
    protected $make;

    public function getId()
    {
        return $this->id;
    }

    public function getModelYear()
    {
        return $this->modelYear;
    }

    public function getMake()
    {
        return $this->make;
    }

    public function getTransmission()
    {
        return $this->transmissionType;
    }

    public function getLicense()
    {
        return $this->license;
    }

    public function getPurchased()
    {
        return $this->purchased;
    }

    public function getEngineSize()
    {
        return $this->engineSize;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getImage()
    {
        return $this->image;
    }
}

?>