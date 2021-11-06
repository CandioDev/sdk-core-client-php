<?php declare(strict_types = 1);

namespace Candio\CoreClient\DI;

use Candio\CoreClient\CoreClient;
use Candio\CoreClient\CoreConfig;
use Nette\Caching\IStorage;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use RuntimeException;
use stdClass;

/**
 * @property-read stdClass $config
 */
final class CandioCoreExtension extends CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'connection' => Expect::structure([
				'uri' => Expect::string('http://candio-core:8080/'),
				'ident' => Expect::string(),
				'cache' => Expect::bool(false),
			]),
		]);
	}

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->config;

		$builder->addDefinition($this->prefix('connection.core'))
			->setFactory(CoreClient::class)
			->setArguments([$config->connection->uri, 'https://candio.vcap.me/'])
			->setAutowired(true);
//exit;
		$builder->addDefinition($this->prefix('config'))
			->setFactory(CoreConfig::class)
			->setAutowired(true);
	}

	public function beforeCompile(): void
	{
//		$this->beforeCompileStorage();
//		$this->beforeCompileSession();
	}

	public function beforeCompileStorage(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->config;

		foreach ($config->connection as $name => $connection) {
			$autowired = $name === 'default';

			// Skip if replacing storage is disabled
			if (!$connection->storage) {
				continue;
			}

			// Validate needed services
			if ($builder->getByType(IStorage::class) === null) {
				throw new RuntimeException(sprintf('Please install nette/caching package. %s is required', IStorage::class));
			}

		}
	}

//	public function afterCompile(ClassType $class): void
//	{
//		$config = $this->config;
//
//		if ($config->debug && $config->connection !== []) {
//			$initialize = $class->getMethod('initialize');
//			$initialize->addBody('$this->getService(?)->addPanel($this->getService(?));', ['tracy.bar', $this->prefix('panel')]);
//		}
//	}

}
