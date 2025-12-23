<?php

declare(strict_types=1);

namespace hazeld\trollxd\troll;

use dktapps\pmforms\MenuForm;
use dktapps\pmforms\MenuOption;
use hazeld\trollxd\Loader;
use hazeld\trollxd\trolls\BlindnessTroll;
use hazeld\trollxd\trolls\FakeOpTroll;
use hazeld\trollxd\utils\Translator;
use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;

final class TrollManager
{
	use SingletonTrait;

	private Loader $plugin;
	private TrollRegistry $registry;

	public function init(Loader $plugin): void
	{
		$this->plugin = $plugin;
		$this->registry = new TrollRegistry();
	}

	public function registerTrolls(): void
	{
		$this->registry->register(new BlindnessTroll());
		$this->registry->register(new FakeOpTroll());
	}

	public function openTrollMenu(Player $player, Player $target): void
	{
		$trolls = $this->registry->all();
		if (count($trolls) === 0) {
			$player->sendMessage(Translator::getInstance()->translate("errors.no_trolls"));
			return;
		}

		$options = [];
		foreach ($trolls as $troll) {
			$label = TextFormat::BOLD . TextFormat::DARK_AQUA . $troll->getName() . TextFormat::RESET;
			$desc = $troll->getDescription();
			$options[] = new MenuOption($desc === "" ? $label : "{$label}\n{$desc}");
		}

		$form = new MenuForm(
			Translator::getInstance()->translate("menu.main_title"),
			Translator::getInstance()->translate("menu.main_text", ["target" => $target->getName()]),
			$options,
			function (Player $player, int $selected) use ($trolls, $target): void {
				$troll = $trolls[$selected] ?? null;
				if ($troll === null) {
					return;
				}

				if (!$troll->execute($target)) {
					$reasons = $troll->getRequirementErrors($player);
					$message = "Can't run '{$troll->getName()}'";
					if ($reasons !== []) {
						$message .= ": " . implode("; ", $reasons);
					}
					$player->sendMessage($message);
					return;
				}

				$player->sendMessage("Executed '{$troll->getName()}' on '{$target->getName()}'");
			}
		);
		$player->sendForm($form);
	}

	public function getPlugin(): Loader
	{
		return $this->plugin;
	}

	public function getRegistry(): TrollRegistry
	{
		return $this->registry;
	}
}
