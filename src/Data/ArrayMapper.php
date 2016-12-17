<?php

namespace Reify\Data;


use Reify\IMapper;
use Reify\Map\MapObject;
use Reify\Map\MapProperty;

/**
 * Can map an array to a concrete class
 *
 * Class ArrayMapper
 * @package Reify\Data
 */
class ArrayMapper implements IMapper
{
	/**
	 * @param array $data
	 * @param MapObject $class
	 * @return mixed
	 */
	public function map($data, MapObject $class)
	{
		// Get the instance of the class we want to map the data to
		$object = $class->getInstance();

		foreach ($data as $propertyName => $value) {
			// Map every property in the first dimension
			$this->mapProperty($class->getProperty($propertyName), $value, $object);
		}

		return $object;

		// Whether the item we want to map is a single item
		$isSingleItem = is_object($data) || $this->isAssoc($data);

		if ($isSingleItem) {
			// Loop trough every property in the data
			foreach ($data as $propertyName => $value) {
				// Map every property in the first dimension
				$this->mapProperty($class->getProperty($propertyName), $value, $object);
			}

			return $object;
		// Otherwise it is a list with multiple items
		} else {
			// Stores the mapped objects
			$objects = [];
			// Loop through every item
			foreach($data as $item) {
				// Loop trough every property in the item
				foreach($item as $propertyName => $value) {
					$this->mapProperty($class->getProperty($propertyName), $value, $object);
				}

				$objects[] = $object;
			}

			return $objects;
		}
	}

	/**
	 * @param $data
	 * @return mixed
	 */
	public function validate($data)
	{
		return is_array($data) || is_object($data);
	}

	/**
	 * @param $data
	 * @param MapObject $class
	 * @return array
	 */
	public function mapCollection($data, MapObject $class)
	{
		// Get the instance of the class we want to map the data to
		$object = $class->getInstance();
	}

	/**
	 *
	 *
	 * @param MapProperty $property
	 * @param MapObject $object
	 */
	private function mapProperty($property, $value, &$object)
	{
		if ($property) {
			$propertyName = $property->getName();
			$propertyType = $property->getType();

			if (is_array($value)) {
				foreach($value as $item) {
					$this->mapProperty($property, $item, $object);
				}
			} else {
				if (MapProperty::isPrimitive($propertyType)) {
					$object->$propertyName = $value;
				} else {
					$mapObject = $property->getMappedObject();
					$propertyObject = $mapObject->getInstance();

					foreach($value as $name => $propertyValue) {
						$this->mapProperty($mapObject->getProperty($name), $propertyValue, $propertyObject);
					}

					if ($property->isCollection()) {
						if (!isset($object->$propertyName)) {
							$object->$propertyName = [];
						}

						$object->{$propertyName}[] = $propertyObject;
					}  else {
						$object->$propertyName = $propertyObject;
					}
				}
			}
		}
	}

	private function isAssoc($array)
	{
		if ([] === $array) return false;
		return array_keys($array) !== range(0, count($array) - 1);
	}
}