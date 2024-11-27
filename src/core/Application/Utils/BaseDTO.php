<?php

namespace Core\Application\Utils;

use Core\Domain\Utils\BaseDTOContract;
use InvalidArgumentException;

class BaseDTO implements BaseDTOContract
{
    /**
     * Method values
     */
    public function values(): array
    {
        return get_object_vars($this);
    }

    /**
     * Method get
     *
     *
     * @return mixed
     */
    public function get(string $property)
    {
        $getter = 'get'.ucfirst($property);

        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }

        if (! property_exists($this, $property)) {
            throw new InvalidArgumentException(sprintf(
                "The property '%s' doesn't exists in '%s' DTO Class",
                $property,
                get_class()
            ));
        }

        return $this->{$property};
    }

    /**
     * Method jsonSerialize
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->values();
    }
}
