<?php

namespace Spotify\Track;

use \App\Spotify\Object\PagingObject as BasePagingObject;

class PagingObject extends BasePagingObject
{

	/**
	 * @var \App\Spotify\Object\Track[]
	 */
	public $items;
}