<?php

namespace Cars\Form;

use Zend\Form\Form;

/**
 * An object that represents form data to be inserted into the ViewModel
 * @author jon
 *
 */
class NewCarForm extends Form
{
    /**
     *
     * @param array $makes
     * @param array $transmissions
     * @param array $bodyTypes
     * @param string $name
     */
    function __construct($makes, $transmissions, $bodyTypes, $name = null)
    {
        srand(time());
        $rand = rand(100, 1000);
        parent::__construct('NewCar');
        $this->setAttribute('method', 'post')
            ->setAttribute('enctype', 'multipart/form-data')
            ->setAttribute('class', 'form-horizontal')
            ->setAttribute('action', 'save')
            ->setAttribute('id', 'form' . $rand)
            ->setAttribute('role', 'form');

        // License
        $this->add(array(
            'name' => 'license',
            'attributes' => array(
                'type' => 'text',
                'maxlength' => 10,
                'class' => 'form-control',
                'title' => 'Enter the registration number',
                'placeholder' => 'Registration number',
                'required' => 'required'
            ),
            'options' => array(
                'label' => 'Registration'
            )
        ))
            ->
            // Purchased
            add(array(
                'name' => 'purchased',
                'attributes' => array(
                    'type' => 'text',
                    'maxlength' => 10,
                    'class' => 'form-control',
                    'title' => 'Enter the purchase date',
                    'placeholder' => 'Purchase date',
                    'required' => 'required',
                    'id' => 'purchased'
                ),
                'options' => array(
                    'label' => 'Purchased'
                )
            ))
            ->
            // image
            add(array(
                'name' => 'image',
                'attributes' => array(
                    'type' => 'text',
                    'maxlength' => 10,
                    'class' => 'form-control',
                    'title' => 'Enter the name of the image',
                    'placeholder' => 'image name',
                    'required' => 'required',
                    'id' => 'image'
                ),
                'options' => array(
                    'label' => 'Image'
                )
            ))
            ->
            // Model year
            add(array(
                'name' => 'modelyear',
                'attributes' => (array(
                    'type' => 'number',
                    'maxlength' => 4,
                    'class' => 'form-control',
                    'title' => 'Enter the model year',
                    'placeholder' => 'Enter the year like 2014 for example',
                    'required' => 'required',
                    'pattern' => '^\d{4}$',
                    'min' => 1960,
                    'max' => 2050
                )),
                'options' => array(
                    'label' => 'Model Year'
                )
            ))
            ->
            add(array(
                'name' => 'enginesize',
                'attributes' => (array(
                    'type' => 'text',
                    'maxlength' => 4,
                    'class' => 'form-control',
                    'title' => 'Enter the engine size',
                    'placeholder' => 'Enter the engine size',
                    'required' => 'required',
                    'pattern' => '^[1-6].[\d{1}]$'
                )),
                'options' => array(
                    'label' => 'Engine Size'
                )
            ))
            ->
            // Model
            add(array(
                'type' => 'Zend\Form\Element\Text',
                'name' => 'model',
                'attributes' => array(
                    'class' => 'form-control',
                    'type' => 'text',
                    'required' => 'required',
                    'max-length' => 45,
                    'title' => 'Enter the model',
                    'placeholder' => 'Model name'
                ),
                'options' => array(
                    'label' => 'Model'
                )
            ))
            ->
            // Cost
            add(array(
                'name' => 'cost',
                'attributes' => (array(
                    'type' => 'number',
                    'maxlength' => 6,
                    'class' => 'form-control',
                    'title' => 'Enter the cost in whole $ like 10000 for example',
                    'placeholder' => 'Enter a whole $ value',
                    'required' => 'required',
                    'min' => 100,
                    'max' => 120000,
                    'step' => 1
                )),
                'options' => array(
                    'label' => 'Purchase Price'
                )
            ))
            ->
            // Makes
            add(array(
                'type' => 'Zend\Form\Element\Select',
                'name' => 'make',
                'attributes' => array(
                    'value' => '1',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'label' => 'Make',
                    'value_options' => $makes
                )
            ))
            ->
            // Transmissions
            add(array(
                'type' => 'Zend\Form\Element\Select',
                'name' => 'transmission',
                'attributes' => array(
                    'value' => '1',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'label' => 'Transmission',
                    'value_options' => $transmissions
                )
            ))
            ->
            // Cylinders
            add(array(
                'type' => 'Zend\Form\Element\Radio',
                'name' => 'cylinders',
                'attributes' => array(
                    'value' => '1',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'label' => 'Cylinders',
                    'value_options' => array(
                        '1' => '4',
                        '2' => '3',
                        '3' => '6'
                    )
                )
            ))
            ->
            // Body types
            add(array(
                'type' => 'Zend\Form\Element\Select',
                'name' => 'bodytype',
                'attributes' => array(
                    'value' => '1',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'label' => 'Body type',
                    'value_options' => $bodyTypes
                )
            ));
    }

    /**
     */
    function __destruct()
    {
        // TODO - Insert your code here
    }
}

?>