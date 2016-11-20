<?php

namespace Spotify\Album;

use App\Spotify\Object\Album;
use \App\Spotify\Object\PagingObject as BasePagingObject;

class PagingObject extends BasePagingObject
{

	/**
	 * @var \App\Spotify\Object\Album[]
	 */
	public $items;
}