<?php

namespace Spotify\Artist;

use \App\Spotify\Object\PagingObject as BasePagingObject;

class PagingObject extends BasePagingObject
{

	/**
	 * @var \App\Spotify\Object\Artist[]
	 */
	public $items;
}