<?php

namespace Mapper;

interface IMapper
{
	/**
	 * @param mixed $data
	 * @param $object
	 */
	public function map($data, $object);
}