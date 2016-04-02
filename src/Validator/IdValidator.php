<?php

namespace T4web\Crud\Validator;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;

class IdValidator extends BaseValidator
{
    public function __construct(EntityExistValidator $entityExistValidator)
    {
        $this->inputFilter = new InputFilter();

        $id = new Input('id');
        $id->getValidatorChain()
            ->attachByName('Digits')
            ->attachByName(
                'GreaterThan',
                [
                    'min' => 0,
                ]
            );
        $id->getValidatorChain()->attach($entityExistValidator);

        $this->inputFilter->add($id);
    }
}
