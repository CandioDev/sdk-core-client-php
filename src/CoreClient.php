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
	 * @var array|null
	 */
	private ?array $configData = null;

	/**
	 * @param string $url
	 * @param string $value
	 */
	public function __construct(string $url, protected string $value) {
		$this->client = new Client(['base_uri' => $url]);
	}

	protected function fetch(string $method, string $url, ?array $params) {
		return json_decode((string) $this->client->{$method}($url, $params)->getBody(), true);
	}

	public function getConfig() {
		if (!$this->configData) {
			$this->configData = $this->fetchConfig($this->value);
		}

		return $this->configData;
	}

	public function fetchConfig($filter) {
		return $this->fetch('get','get', ['filter' => $filter]);
	}

}
