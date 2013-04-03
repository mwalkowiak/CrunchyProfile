<?php

namespace CrunchyProfile\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;

class AbstractEntity
{
	public function toArray()
	{
		$hydrator = new ClassMethods();
		$hydrator->setUnderscoreSeparatedKeys(false);
		return $hydrator->extract($this);
	}

    public function exchangeArray(array $data)
    {
        $hydrator = new ClassMethods();
        $hydrator->setUnderscoreSeparatedKeys(false);
        return $hydrator->hydrate($data, $this);
    }

}