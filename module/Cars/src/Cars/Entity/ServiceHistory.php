<?php
namespace Cars\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter as InputFilter;

/**
 *
 * @author jonathan
 *        
 *         @ORM\Entity
 *         @ORM\Table(name="ServiceHistory")
 * @property integer $rid
 * @property integer $supplierid
 * @property date $date
 * @property decimal $cost
 * @property string $comments
 * @property string $invoicenumber
 * @property integer $odometer
 * @property integer $carid
 *
 */
class ServiceHistory implements InputFilterAwareInterface
{

    protected $inputFilter;

    /**
     * @ORM\Column(type="integer")
     *
     * @var \Doctrine\DBAL\Types\IntegerType
     */
    protected $rid;

    /**
     * @ORM\Column(type="integer")
     *
     * @var \Doctrine\DBAL\Types\IntegerType
     */
    protected $supplierid;

    /**
     * @ORM\Column(type="integer")
     *
     * @var \Doctrine\DBAL\Types\IntegerType
     */
    protected $carid;

    /**
     * @ORM\Column(type="date")
     *
     * @var \Doctrine\DBAL\Types\DateType
     */
    protected $date;

    /**
     * @ORM\Column(type="decimal")
     *
     * @var \Doctrine\DBAL\Types\DecimalType
     */
    protected $cost;

    /**
     * ORM\Column(type="string")
     *
     * @var \Doctrine\DBAL\Types\StringType
     */
    protected $comments;

    /**
     * ORM\Column(type="string")
     *
     * @var \Doctrine\DBAL\Types\StringType
     */
    protected $invoicenumber;

    /**
     * @ORM\Column(type="integer")
     *
     * @var \Doctrine\DBAL\Types\IntegerType
     */
    protected $odometer;

    /*
     * (non-PHPdoc)
     * @see \Zend\InputFilter\InputFilterAwareInterface::getInputFilter()
     */
    public function getInputFilter()
    {
        // TODO Auto-generated method stub
    }

    /*
     * (non-PHPdoc)
     * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
     */
    public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter)
    {
        if (! $this->inputFilter) {
            
            $this->inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'Comments',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                )
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'SupplierId',
                'required' => true,
                'filters' => array(
                    'name' => 'int'
                )
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'Date',
                'required' => true,
                'filters' => array(
                    'name' => 'date'
                )
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'CarId',
                'required' => true,
                'filters' => array(
                    'name' => 'int'
                )
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'InvoiceNumber',
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                )
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'Cost',
                'required' => true,
                'filters' => array(
                    'name' => 'decimal'
                )
            )));
        }
    }

    /**
     * Takes an array and assigns elements to this properties
     *
     * @param array $data            
     */
    public function populate($data = array())
    {
        $this->comments = $data['comments'];
        $this->cost = $data['cost'];
        $this->date = $data['date'];
        $this->invoicenumber = $data['invoicenumber'];
        $this->odometer = $data['odometer'];
        $this->supplierid = $data['supplierid'];
        $this->rid = $data['data'];
        $this->carid = $data['carid'];
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