<?php

namespace T4web\Crud\ViewModel;

use Zend\View\Model\ViewModel;
use T4webDomainInterface\EntityInterface;

class ReadViewModel extends ViewModel
{
    public function getVariable($name, $default = null)
    {
        $variable = parent::getVariable($name, $default);

        if ($name == 'result') {
            if (! $variable instanceof EntityInterface) {
                throw new \RuntimeException('Variable result must be instance of ' . EntityInterface::class . '. '
                    . gettype($variable) . ' given');
            }
            $variable = $variable->extract();
        }

        return $variable;
    }
}
