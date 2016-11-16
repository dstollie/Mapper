<?php

namespace Mapper;

use Exception;
use Mapper\Map\MapObject;

class Mapper
{
	/**
	 * @var IMapper
	 */
	private $mapper;

	/**
	 * @var
	 */
	private $data;

	public function map(IMapper $mapper, $data)
	{
		$this->setMapper($mapper);
		$this->setData($data);

		return $this;
	}

	public function to($class)
	{
		if (!isset($this->mapper)) {
			throw new Exception("Undefined mapper interface");
		}

		return $this->mapper->map($this->data, MapObject::map($class));
	}

	/**
	 * @param mixed $mapper
	 * @return Mapper
	 */
	public function setMapper(IMapper $mapper)
	{
		$this->mapper = $mapper;
		return $this;
	}

	/**
	 * @param mixed $data
	 * @return Mapper
	 */
	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}
}