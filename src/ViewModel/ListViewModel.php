<?php


namespace T4web\Crud\ViewModel;

use Zend\View\Model\ViewModel;
use T4webDomainInterface\EntityInterface;

class ListViewModel extends ViewModel
{
    public function getVariable($name, $default = null)
    {
        $variable = parent::getVariable($name, $default);

        if ($name == 'result') {
            if ($variable !== null) {
                if (! $variable instanceof \ArrayObject) {
                    throw new \RuntimeException('Variable result must be instance of ' . \ArrayObject::class . '. '
                        . gettype($variable) . ' given');
                }
                $result = [];
                foreach ($variable as $entry) {
                    if (! $entry instanceof EntityInterface) {
                        throw new \RuntimeException('Variable result must be instance of ' . EntityInterface::class . '. '
                            . gettype($entry) . ' given');
                    }
                    $result[] = $entry->extract();
                }

                return $result;
            }
        }

        return $variable;
    }
}
