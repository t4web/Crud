<?php

namespace T4web\Crud\Validator;

class BaseFilter extends BaseValidator
{
    /**
     * @param array $data
     *
     * @return bool
     */
    public function isValid($data)
    {
        $this->inputFilter->setData($data);
        $this->inputFilter->isValid($data);

        return true;
    }
}
