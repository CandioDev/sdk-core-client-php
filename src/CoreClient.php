<?php

namespace Candio\CoreClient;

use GuzzleHttp\Client;

/**
 * API client for Core service
 */
class CoreClient {
	/**
	 * @var Client
	 */
	private Client $client;

	/**
	 * @param string $uri
	 */
	public function __construct(string $uri) {
		$this->client = new Client(['base_uri' => $uri]);
	}

	protected function fetch(string $method, string $url, ?array $params) {
		return json_decode((string) $this->client->{$method}($url, $params)->getBody());
	}

	public function getConfigById(string $id) {
		return $this->fetch('get','get', ['id' => $id]);
	}

	public function getConfigByCandioUri($uri) {
		return $this->fetch('get','get', ['candioUrl' => $uri]);
	}

	public function getConfigByPortalUri($uri) {
		return $this->fetch('get','get', ['portalUrl' => $uri]);
	}
}
