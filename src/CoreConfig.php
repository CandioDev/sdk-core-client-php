<?php declare(strict_types = 1);

namespace Candio\CoreClient;

use Candio\CoreClient\CoreClient;
use Nette\Caching\IStorage;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use RuntimeException;
use stdClass;

final class CoreConfig
{
	private ?array $data = null;

	public function __construct(private CoreClient $client) {
	}

	/**
	 * @param string $property
	 * @return mixed
	 */
	public function getConfig(string $property): mixed {
		if (!$this->data) {
			$this->data = $this->client->getConfig();
		}
		return array_key_exists($property, $this->data) ? $this->data[$property] : null;
	}
}
