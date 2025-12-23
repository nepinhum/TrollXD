<?php

declare(strict_types=1);

namespace hazeld\trollxd\command;

use CortexPE\Commando\BaseSubCommand;
use hazeld\trollxd\Loader;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class TrollSubCommand extends BaseSubCommand
{
	protected Loader $plugin;
	protected bool $requiresPlayer = true;

	public function __construct(TrollCommand $parent, string $name, string $description = "", array $aliases = [])
	{
		$this->parent = $parent;
		$this->plugin = $parent->getOwningPlugin();
		$this->setPermission("trollxd.command.troll." . $name);
		parent::__construct($name, $description, $aliases);
	}

	public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
	{
		if (!$sender instanceof Player && $this->requiresPlayer) {
			$sender->sendMessage(TextFormat::RED . "Please use this command in-game.");
			return;
		}

		foreach ($this->getArgumentList() as $arguments) {
			foreach ($arguments as $argument) {
				$name = $argument->getName();
				if (!array_key_exists($name, $args) || $args[$name] === null) {
					if ($argument->isOptional()) {
						continue;
					}

					$this->sendUsage();
					return;
				}
			}
		}

		if ($this->requiresPlayer && $sender instanceof Player) {
			$this->onCasualRun($sender, $aliasUsed, $args);
		} else {
			$this->onJustRun($sender, $args);
		}
	}

	public function onJustRun(CommandSender $sender, array $args): void
	{
	}

	public function onCasualRun(Player $sender, string $aliasUsed, array $args): void
	{

	}

	protected function prepare(): void
	{
	}
}
