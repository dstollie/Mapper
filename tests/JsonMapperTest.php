<?php

namespace Reify\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Reify\Data\JsonMapper;
use Reify\Mapper;
use Spotify\PagedResponse;

class JsonMapperTest extends TestCase
{
	private $jsonData;

	public function getJsonData()
	{
		if ($jsonData) {
			return $jsonData;
		}

		$guzzle = new Client();
		$response = $guzzle->get('https://api.spotify.com/v1/search', [
			'query' => [
				'q' => 'adhesive wombat',
				'type' => 'track'
			]
		]);

		$jsonData = $response->getBody()->getContents();
		return $jsonData;
	}

	public function testJsonMapper()
	{
		$json = $this->getJsonData();

		$mapper = new Mapper();
		$pagedResponse = $mapper->map(new JsonMapper(), $json)->to(PagedResponse::class);

		var_dump($pagedResponse);
	}
}