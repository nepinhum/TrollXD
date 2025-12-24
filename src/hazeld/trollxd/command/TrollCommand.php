<?php

declare(strict_types=1);

namespace hazeld\trollxd\command;

use hazeld\trollxd\Loader;
use hazeld\trollxd\troll\TrollManager;
use hazeld\trollxd\utils\Translator;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

final class TrollCommand extends Command
{
	private Loader $plugin;

	public function __construct(Loader $plugin)
	{
		$this->plugin = $plugin;
		$this->setPermission("trollxd.command.troll.use");
		parent::__construct("troll", "TrollXD main command", "/troll <playerName>", []);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args): void
	{
		if (!$sender instanceof Player) {
			$sender->sendMessage(Translator::getInstance()->translate("errors.command.only_game"));
			return;
		}

		if (!isset($args[0])) {
			$sender->sendMessage(Translator::getInstance()->translate("errors.command.usage"));
			return;
		}

		$target = $args[0];
		$targetPlayer = $this->plugin->getServer()->getPlayerByPrefix($target); // make it exact
		if (!$targetPlayer) {
			$sender->sendMessage(Translator::getInstance()->translate("errors.command.player_not_found"));
			return;
		}

		TrollManager::getInstance()->openTrollMenu($sender, $targetPlayer);
	}
}
