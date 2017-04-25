<?php

namespace Cars\Form;

use Zend\Form\Form;

class ServiceRecordForm extends Form
{

    function __construct($carId, $suppliers)
    {
        srand(time());
        $rand = rand(100, 1000);
        parent::__construct('ServiceRecord');
        $this->setAttribute('method', 'post')
            ->setAttribute('enctype', 'multipart/form-data')
            ->setAttribute('class', 'form-horizontal')
            ->setAttribute('id', 'form' . $rand)
            ->setAttribute('role', 'form');

        $this->add(array(
            'name' => 'carId',
            'type' => 'Zend\Form\Element\Hidden',
            'attributes' => array(
                'value' => $carId,
                'id' => 'cardId'
            )
        ));

        $this->add(array(
            'name' => 'date',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'type' => 'date',
                'required' => 'required',
                'class' => 'form-control',
                'id' => 'servicedate',
                'title' => 'Select a date',
                'name' => 'servicedate'
            ),
            'options' => array(
                'label' => 'Date'
            )
        ));

        $this->add(array(
            'name' => 'cost',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'type' => 'text',
                'maxlength' => 6,
                'required' => 'required',
                'class' => 'form-control',
                'title' => 'Enter the total cost in dollars',
                'required' => 'required',
                'id' => 'cost'
            ),
            'options' => array(
                'label' => 'Cost'
            )
        ));

        $this->add(array(
            'name' => 'comments',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control',
                'cols' => 40,
                'rows' => 10,
                'title' => 'Enter a description and any notes',
                'placeholder' => 'Enter a description',
                'id' => 'comments'
            ),
            'options' => array(
                'label' => 'Notes'
            ),
            'type' => 'Zend\Form\Element\Textarea'
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'supplierid',
            'attributes' => array(
                'value' => '1',
                'class' => 'form-control',
                'title' => 'Select a provider',
                'id' => 'supplierId'
            ),
            'options' => array(
                'label' => 'Provider',
                'value_options' => $suppliers
            )
        ));

        $this->add(array(
            'name' => 'invoicenumber',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'type' => 'text',
                'maxlength' => 20,
                'required' => 'required',
                'class' => 'form-control',
                'title' => 'Enter the invoice number',
                'required' => 'required',
                'placeholder' => 'Invoice number',
                'id' => 'invoiceNumber'
            ),
            'options' => array(
                'label' => 'Invoice'
            )
        ));

        $this->add(array(
            'name' => 'odometer',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'type' => 'number',
                'maxlength' => 20,
                'required' => 'required',
                'class' => 'form-control',
                'title' => 'Enter the odo reading',
                'required' => 'required',
                'id' => 'odometer'
            ),
            'options' => array(
                'label' => 'Odo'
            )
        ));
    }
}

?>