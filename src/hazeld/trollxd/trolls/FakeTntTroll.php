<?php

declare(strict_types=1);

namespace hazeld\trollxd\trolls;

use hazeld\trollxd\others\entity\FakePrimedTNT;
use hazeld\trollxd\troll\Troll;
use hazeld\trollxd\troll\TrollRequirement;
use hazeld\trollxd\utils\Translator;
use pocketmine\player\Player;

final class FakeTntTroll extends Troll implements TrollRequirement
{
	public function __construct()
	{
		parent::__construct("faketnt", Translator::getInstance()->translate("trolls.descriptions.faketnt"));
	}

	protected function onExecute(Player $target): void
	{
		$target->sendMessage(Translator::getInstance()->translate("trolls.messages.faketnt"));
		$entity = new FakePrimedTNT($target->getLocation()); //without explodeA()
		$entity->spawnToAll();
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
