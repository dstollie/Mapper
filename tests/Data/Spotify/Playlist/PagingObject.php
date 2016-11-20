<?php

namespace Spotify\Playlist;

use \App\Spotify\Object\PagingObject as BasePagingObject;

class PagingObject extends BasePagingObject
{

	/**
	 * @var \App\Spotify\Object\Playlist[]
	 */
	public $items;
}