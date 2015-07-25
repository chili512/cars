<?php
namespace Cars\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;

/**
 * A car
 *
 * @author jon
 *        
 *         @ORM\Entity
 *         @ORM\Table(name="Autos")
 * @property integer $Id
 * @property integer $Make
 * @property integer $Model
 * @property string $License
 * @property date $Purchased
 * @property integer $ModelYear
 * @property decimal $EngineSize
 * @property integer $Cylinders
 * @property integer $Transmission
 * @property integer $BodyType
 * @property decimal $Cost
 * @property string $Image
 */
class Automobile implements InputFilterAwareInterface
{

    /**
     *
     * @var InputFilter
     */
    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $Id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $Make;

    /**
     * @ORM\Column(type="integer")
     */
    protected $Model;

    /**
     * @ORM\Column(type="string")
     */
    protected $License;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=false)
     */
    protected $Purchased;

    /**
     * @ORM\Column(type="integer")
     */
    protected $ModelYear;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $EngineSize;

    /**
     * @ORM\Column(type="integer")
     */
    protected $Cylinders;

    /**
     * @ORM\Column(type="integer")
     */
    protected $Transmission;

    /**
     * @ORM\Column(type="integer")
     */
    protected $BodyType;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $Cost;

    /**
     * @ORM\Column(type="string")
     */
    protected $Image;

    /**
     * Magic getter to expose protected properties
     *
     * @param string $property            
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * Magic setter to save protected properties
     *
     *
     * @param string $property            
     * @param mixed $value            
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    /**
     * Convert the object to an array
     *
     * @return array:
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * Populate from an array
     *
     * @param array $data            
     */
    public function exchangeArray($data = array())
    {
        $this->BodyType = $data['bodytype'];
        $this->Cost = $data['cost'];
        $this->Cylinders = $data['cylinders'];
        $this->EngineSize = $data['enginesize'];
        $this->Image = $data['image'];
        $this->License = $data['license'];
        $this->Make = $data['make'];
        $this->Model = $data['model'];
        $this->ModelYear = $data['modelyear'];
        $this->Purchased = $data['purchased'];
        $this->Transmission = $data['transmission'];
    }
    
    /*
     * (non-PHPdoc)
     * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
     */
    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    
    /*
     * (non-PHPdoc)
     * @see \Zend\InputFilter\InputFilterAwareInterface::getInputFilter()
     */
    public function getInputFilter()
    {
        // TODO Auto-generated method stub
        return null;
    }
}

?>