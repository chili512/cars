<?php
namespace Cars\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @author jonathan
 *        
 *         @ORM\Entity
 *         @ORM\Table(name="Suppliers")        
 */
class Suppliers
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="SupplierId", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $Id;

    /**
     * @ORM\Column(type="string", name="name", nullable=false)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="ServiceHistory", mappedBy="Suppliers")
     */
    protected $services;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function setId($id)
    {
        $this->Id = $id;
    }

    public function getId()
    {
        return $this->Id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}