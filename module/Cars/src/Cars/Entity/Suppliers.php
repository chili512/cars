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
 *
 */
class Suppliers
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer", name="supplierId", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO") 
     */
    protected $supplierId;

    /**
     * @var string
     * @ORM\Column(type="string", name="name", nullable=false)
     */
    protected $name;

    /**
     *
     * @var Collection 
     * @OneToMany(targetEntity="ServiceHistory", mappedBy="servicehistory")
     */
    protected $servicehistorys;

    /**
     * 
     */
    public function __construct()
    {
        $this->servicehistorys = new ArrayCollection();
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $property            
     * @param mixed $value            
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property            
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}

?>