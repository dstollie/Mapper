<?php

namespace Reify\Data;

use Reify\Map\MapObject;

class JsonMapper extends ArrayMapper
{
	/**
	 * @param array $data
	 * @param MapObject $object
	 * @return mixed
	 */
	public function map($data, $object)
	{
		if (!is_string($data)) {
			throw new \InvalidArgumentException('Expected json to be string');
		}

		$decodedData = json_decode($data);

		if (!$decodedData) {
			throw new \InvalidArgumentException(json_last_error_msg());
		}

		return parent::map($decodedData, $object);
	}
}