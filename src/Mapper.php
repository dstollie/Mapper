<?php

namespace Reify;

use Exception;
use Reify\Map\MapObject;

/**
 * The main class which is the orchestrator of the whole mapping process
 *
 * Class Mapper
 * @package Reify
 */
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

		if(!$this->mapper->validate($this->data))
		{
			throw new \InvalidArgumentException();
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