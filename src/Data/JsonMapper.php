<?php

namespace Reify\Data;

use Reify\Map\MapObject;

class JsonMapper extends ArrayMapper
{
	/**
	 * @inheritdoc
	 */
	public function map($data, MapObject $class)
	{
		if (!is_string($data)) {
			throw new \InvalidArgumentException('Expected json to be string');
		}

		$decodedData = json_decode($data);

		if (!$decodedData) {
			throw new \InvalidArgumentException(json_last_error_msg());
		}

		return parent::map($decodedData, $class);
	}

	/**
	 * @inheritdoc
	 */
	public function validate($data)
	{
		json_decode($data);
		return (json_last_error() == JSON_ERROR_NONE);
	}

}