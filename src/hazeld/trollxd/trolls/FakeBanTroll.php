<?php

declare(strict_types=1);

namespace hazeld\trollxd\trolls;

use hazeld\trollxd\troll\Troll;
use hazeld\trollxd\troll\TrollRequirement;
use hazeld\trollxd\utils\Translator;
use pocketmine\player\Player;

final class FakeBanTroll extends Troll implements TrollRequirement
{
	public function __construct()
	{
		parent::__construct("fakeban", Translator::getInstance()->translate("trolls.descriptions.fakeban"));
	}

	protected function onExecute(Player $target): void
	{
		$target->kick("TrollXD FakeBan", null, Translator::getInstance()->translate("trolls.descriptions.fakeban"));
	}

	public function isSatisfied(Player $target): bool
	{
		return $target->isOnline();
	}

	public function getReason(): string
	{
		return "Target must be online.";
	}
}
