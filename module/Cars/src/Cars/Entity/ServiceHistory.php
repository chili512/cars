<?php
namespace Cars\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter as InputFilter;

/**
 *
 * @author jonathan
 *        
 *         @ORM\Entity
 *         @ORM\Table(name="ServiceHistory")
 *        
 */
class ServiceHistory implements InputFilterAwareInterface
{

    protected $inputFilter;

    /**
     *
     * @var int 
     * 
     * @ORM\Id
     * @ORM\Column(type="integer", name="rid", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $rid;

    /**
     *
     * @var int @ORM\Column(type="integer")
     */
    protected $supplierid;

    /**
     *
     * @var Suppliers 
     * 
     * @ManyToOne(targetEntity="Suppliers", inversedBy="servicehistorys")
     * @JoinColumn(name="supplierId", referencedColumnName="supplierId") *
     */
    protected $suppliers;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $carid;

    /**
     * @ORM\Column(type="date")
     *
     * @var date
     */
    protected $date;

    /**
     * @ORM\Column(type="decimal")
     *
     * @var decimal
     */
    protected $cost;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $comments;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $invoicenumber;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int
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