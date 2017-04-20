<?php

namespace Cars\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;

/**
 *
 * @author jon
 *
 * @ORM\Entity
 * @ORM\Table(name="AutosOverview")
 * @property integer $id
 * @property string $make
 * @property string $model
 * @property string $image
 * @property integer $modelyear
 *
 */
class Overview implements InputFilterAwareInterface
{

    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var The primary key for the car
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var The make of car
     */
    private $make;

    /**
     * @ORM\Column(type="string")
     *
     * @var unknown
     */
    private $model;

    /**
     * @ORM\Column(type="string")
     *
     * @var unknown
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     *
     * @var unknown
     */
    private $modelyear;

    /**
     *
     * @return \Cars\Entity\unknown
     */
    public function getModelYear()
    {
        return $this->modelyear;
    }

    /**
     *
     * @return \Cars\Entity\unknown
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     *
     * @return \Cars\Entity\unknown
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     *
     * @return \Cars\Entity\The
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     *
     * @return \Cars\Entity\The
     */
    public function getId()
    {
        return $this->id;
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
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array())
    {
        $this->id = $data['id'];
        $this->make = $data['make'];
        $this->model = $data['model'];
        $this->image = $data['image'];
        $this->modelyear = $data['modelyear'];
    }

    /*
     * (non-PHPdoc)
     * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
     */
    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter)
    {
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \Zend\InputFilter\InputFilterAwareInterface::getInputFilter()
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {

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
                'name' => 'make',
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
                            'min' => 1,
                            'max' => 100
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'model',
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
                            'min' => 1,
                            'max' => 100
                        )
                    )
                )
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'image',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'string'
                    )
                )
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

?>