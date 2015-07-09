<?php
namespace Jfa\Form;

use Zend\Form\Form;

class IngredientForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('ingredient');

        $this->add(array(
            'name' => 'ingrID',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'ingrName',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name',
            ),
        ));
        $this->add(array(
            'name' => 'kcalPer100g',
            'type' => 'Number',
            'options' => array(
                'label' => 'Kcal (100g)',
            ),
        ));
        $this->add(array(
           'name' => 'isVeggie',
           'type' => 'Checkbox',
           'options' => array(
                'label' => 'Veggetable',
           ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}