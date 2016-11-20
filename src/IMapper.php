<?php

namespace Reify;

use Reify\Map\MapObject;

interface IMapper
{
	/**
	 * @param mixed $data
	 * @param MapObject $class
	 * @return mixed;
	 */
	public function map($data, $class);
}