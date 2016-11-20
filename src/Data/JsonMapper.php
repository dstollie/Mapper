<?php

namespace Reify\Data;

use Reify\IMapper;
use Reify\Map\MapObject;
use Reify\Map\MapProperty;
use Traversable;

class JsonMapper implements IMapper
{
	/**
	 * @param string $data
	 * @param MapObject $class
	 * @return mixed
	 */
	public function map($data, $class)
	{
		if (!is_string($data)) {
			throw new \InvalidArgumentException('Expected json to be string');
		}

		$decodedData = json_decode($data);

		if (!$decodedData) {
			throw new \InvalidArgumentException(json_last_error_msg());
		}

		$object = $class->getInstance();

		foreach ($decodedData as $propertyName => $value) {
			$this->mapProperty($class->getProperty($propertyName), $value, $object);
		}

		return $object;
	}

	/**
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
}