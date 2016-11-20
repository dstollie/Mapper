<?php

namespace Reify\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Reify\Data\JsonMapper;
use Reify\Mapper;
use Spotify\PagedResponse;
use Spotify\Track;

class JsonMapperTest extends TestCase
{
	private $jsonData;

	public function getJsonData()
	{
		if ($this->jsonData) {
			return $this->jsonData;
		}

		$guzzle = new Client();
		$response = $guzzle->get('https://api.spotify.com/v1/search', [
			'query' => [
				'q' => 'adhesive wombat',
				'type' => 'track'
			]
		]);

		$this->jsonData = $response->getBody()->getContents();
		return $this->jsonData;
	}

	public function testJsonMapping()
	{
		$json = $this->getJsonData();

		$mapper = new Mapper();
		$pagedResponse = $mapper->map(new JsonMapper(), $json)->to(PagedResponse::class);

		$this->assertTrue($pagedResponse instanceof PagedResponse);
	}

	public function testJsonArrayRoot()
	{
		$decodedJson = json_decode($this->getJsonData());
		$json = json_encode($decodedJson->tracks->items);

		$mapper = new Mapper();
		$tracks = $mapper->map(new JsonMapper(), $json)->to(Track::class);

		$this->assertCount(count($decodedJson->tracks->items), $tracks);
		$this->assertTrue(is_array($tracks));
	}
}