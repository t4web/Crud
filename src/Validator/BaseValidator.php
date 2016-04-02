<?php

namespace T4web\Crud\Validator;

use Sebaks\Controller\ValidatorInterface;
use Zend\InputFilter\InputFilter;

class BaseValidator implements ValidatorInterface
{
    /**
     * @var InputFilter
     */
    protected $inputFilter;

    public function __construct()
    {
        $this->inputFilter = new InputFilter();
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function isValid($data)
    {
        $this->inputFilter->setData($data);

        return $this->inputFilter->isValid($data);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->inputFilter->getMessages();
    }

    /**
     * @return array
     */
    public function getValid()
    {
        $validInput = $this->inputFilter->getValidInput();

        $valid = [];
        foreach ($validInput as $name => $input) {
            $value = $input->getValue();
            $empty = ($value === null || $value === '' || $value === []);
            if (!$empty) {
                $valid[$name] = $input->getValue();
            }
        }

        return $valid;
    }
}
