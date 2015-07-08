<?php
namespace Jfa\Form;

use Zend\Form\Form;

class JunkFoodForm extends Form
{
    public $ingredients = array();

    public function __construct($types, $ingredients, $name = null)
    {
        $this->ingredients = $ingredients;

        // we want to ignore the name passed
        parent::__construct('junkfood');

        $this->add(array(
            'name' => 'junkfoodID',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name',
            ),
        ));
        $this->add(array(
            'name' => 'art',
            'type' => 'Select',
            'options' => array(
                'label' => 'Type',
                'value_options' => $types,
            ),
        ));
        $this->add(array(
            'name' => 'isVeggie',
            'type' => 'Select',
            'options' => array(
                'label' => 'Veggie?',
                'value_options' => array(1 => 'Yes', 0 => 'No'),
            ),
        ));
        $this->add(array(
            'name' => 'kcal',
            'type' => 'Text',
            'options' => array(
                'label' => 'Kcal',
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