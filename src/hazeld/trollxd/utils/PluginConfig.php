<?php

declare(strict_types=1);

namespace hazeld\trollxd\utils;

use hazeld\trollxd\Loader;
use pocketmine\utils\Config;

final class PluginConfig
{
	private Loader $instance;

	public function __construct(Loader $instance)
	{
		$this->instance = $instance;
	}

	public function getPluginInstance(): Loader
	{
		return $this->instance;
	}

	public function getPluginConfig(): Config
	{
		return $this->instance->getConfig();
	}

	public function getDefaultLanguage(): string
	{
		return $this->getPluginConfig()->get("defaultLanguage", "en_US");
	}
}
