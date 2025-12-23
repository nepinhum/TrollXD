<?php

declare(strict_types=1);

namespace hazeld\trollxd\command;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseCommand;
use hazeld\trollxd\Loader;
use hazeld\trollxd\troll\TrollManager;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;

final class TrollCommand extends BaseCommand
{
	public function getPermission(): string
	{
		return $this->getPermissions()[0];
	}

	/**
	 * @return Loader
	 */
	public function getOwningPlugin(): Plugin
	{
		return parent::getOwningPlugin();
	}

	protected function prepare(): void
	{
		$this->setPermission("trollxd.command.troll.use");
		$this->registerArgument(0, new RawStringArgument("target"));
	}

	public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
	{
		if (!$sender instanceof Player) {
			return;
		}

		if (isset($args["target"])) {
			$target = $args["target"];
			$targetPlayer = Server::getInstance()->getPlayerByPrefix($target); // make it exact
			if ($targetPlayer !== null) {
				TrollManager::getInstance()->openTrollMenu($sender, $targetPlayer);
			} else {
				$sender->sendMessage("The specified player isn't online!");
			}
		} else {
			$this->sendUsage();
		}
	}
}
