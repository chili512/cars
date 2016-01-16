<?php
namespace Cars\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter as InputFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Db\Sql\Ddl\Column\Integer;

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

    public function __construct()
    {}

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="rid", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @var int
     */
    protected $rid;

    /**
     * @ORM\ManyToOne(targetEntity="Suppliers")
     * @ORM\JoinColumns(
     * {
     * @ORM\JoinColumn(name="supplierid", referencedColumnName="SupplierId")
     * })
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

    public function getRid()
    {
        return $this->rid;
    }

    public function getSupplier()
    {
        return $this->suppliers;
    }

    public function setSupplier($supplier)
    {
        $this->suppliers = $supplier;
    }

    public function setCarId($cardId)
    {
        $this->carid = $cardId;
    }

    public function getCarId()
    {
        return $this->carid;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoicenumber = $invoiceNumber;
    }

    public function getInvoiceNumber()
    {
        return $this->invoicenumber;
    }

    public function setOdometer($odometer)
    {
        $this->odometer = $odometer;
    }

    public function getOdometer()
    {
        return $this->odometer;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    public function getComments()
    {
        return $this->comments;
    }

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