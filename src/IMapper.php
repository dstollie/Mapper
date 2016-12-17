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
	public function map($data, MapObject $class);

	/**
	 * @param $data
	 * @param MapObject $class
	 * @return array
	 */
	public function mapCollection($data, MapObject $class);

	/**
	 * @param $data
	 * @return mixed
	 */
	public function validate($data);
}