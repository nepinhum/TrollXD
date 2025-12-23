<?php

declare(strict_types=1);

namespace hazeld\trollxd;

use CortexPE\Commando\PacketHooker;
use hazeld\trollxd\command\TrollCommand;
use hazeld\trollxd\troll\TrollManager;
use hazeld\trollxd\utils\PluginConfig;
use hazeld\trollxd\utils\Translator;
use hazeld\trollxd\utils\VirionChecker;
use pocketmine\plugin\PluginBase;

final class Loader extends PluginBase
{
	private static self $instance;

	private PluginConfig $pluginConfig;

	protected function onLoad(): void
	{
		self::$instance = $this;
	}

	protected function onEnable(): void
	{
		if (!VirionChecker::checkVirions($this)) {
			$this->getServer()->getPluginManager()->disablePlugin($this);
		}

		if (!PacketHooker::isRegistered())
			PacketHooker::register($this);

		$this->pluginConfig = new PluginConfig($this);
		Translator::getInstance()->init($this);
		TrollManager::getInstance()->init($this);
		TrollManager::getInstance()->registerTrolls();

		$this->getServer()->getCommandMap()->register("troll", new TrollCommand($this, "troll", "Troll command", ["trollxd"]));
	}

	protected function onDisable(): void
	{
	}

	public static function getInstance(): Loader
	{
		return self::$instance;
	}

	public function getPluginConfig(): PluginConfig
	{
		return $this->pluginConfig;
	}
}
