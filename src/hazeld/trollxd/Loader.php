<?php

declare(strict_types=1);

namespace hazeld\trollxd;

use hazeld\trollxd\command\TrollCommand;
use hazeld\trollxd\others\entity\FakePrimedTNT;
use hazeld\trollxd\troll\TrollManager;
use hazeld\trollxd\utils\PluginConfig;
use hazeld\trollxd\utils\Translator;
use hazeld\trollxd\utils\VirionChecker;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\PluginBase;
use pocketmine\world\World;

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

		$this->pluginConfig = new PluginConfig($this);
		Translator::getInstance()->init($this);
		TrollManager::getInstance()->init($this);
		TrollManager::getInstance()->registerTrolls();

		$this->getServer()->getCommandMap()->register("troll", new TrollCommand($this));
		EntityFactory::getInstance()->register(FakePrimedTNT::class, function (World $world, CompoundTag $nbt): FakePrimedTNT {
			return new FakePrimedTNT(EntityDataHelper::parseLocation($nbt, $world));
		}, ["FakePrimedTNT", "minecraft:fake_primed_tnt"]);
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
