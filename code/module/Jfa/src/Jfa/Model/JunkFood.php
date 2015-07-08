<?php
namespace Jfa\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class JunkFood
{
    public $junkfoodID;
    public $userID;
    public $name;
    public $imgPath;
    public $art;
    public $kcal;
    public $isVeggie = false;

    public $ingredients = array();

    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->junkfoodID = (!empty($data['junkfoodID'])) ? $data['junkfoodID'] : null;
        $this->userID = (!empty($data['userID'])) ? $data['userID'] : null;
        $this->name  = (!empty($data['name'])) ? $data['name'] : null;
        $this->imgPath = (!empty($data['imgPath'])) ? $data['imgPath'] : null;
        $this->art  = (!empty($data['art'])) ? $data['art'] : null;
        $this->kcal = (!empty($data['kcal'])) ? $data['kcal'] : null; ;
        $this->isVeggie = (!empty($data['isVeggie'])) ? $data['isVeggie'] : false;
        $this->ingredients = (!empty($data['ingredients'])) ? $data['ingredients'] : array();
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'junkfooID',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'art',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'userID',
                'required' => false,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'kcal',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 50,
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}