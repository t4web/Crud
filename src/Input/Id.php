<?php

namespace T4web\Crud\Input;

use Zend\InputFilter\Input;

class Id extends Input
{
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->getFilterChain()
            ->attachByName('StringTrim');
        $this->getValidatorChain()
            ->attachByName('Digits')
            ->attachByName(
                'GreaterThan',
                [
                    'min' => 0,
                ]
            );
    }
}
