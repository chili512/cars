<?php
namespace Cars\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="Makes")
 *
 * @property integer $id
 * @property string $name
 *
 * @author jon
 *
 */
class Manufacturer  implements InputFilterAwareInterface
{
    protected $inputFilter;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var A primary key
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     *
     * @var The type of body
     */
    private $name;
    
    /**
     *
     * @return \Cars\Entity\A
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     *
     * @return \Cars\Entity\The
     */
    public function getName(){
        return $this->name;
    }
    
    /**
     * Magic setter
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
    }
    
    /**
     * Convert an object to an array
     *
     * @return multitype:
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    /**
     * Populate from an array
     *
     * @param unknown $data
     */
    public function populate($data = array())
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
    }
    
    /*
     * (non-PHPdoc)
     * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
     */
    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter)
    {
        // TODO Auto-generated method stub
        return;
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see \Zend\InputFilter\InputFilterAwareInterface::getInputFilter()
     */
    public function getInputFilter()
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
    
            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'Int'
                    )
                )
            )));
            $inputFilter->add($factory->createInput(array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 45
                        )
                    )
                )
            )));
        }
    
        return $this->inputFilter;
    }
}

?>