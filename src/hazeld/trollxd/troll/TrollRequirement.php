<?php

declare(strict_types=1);

namespace hazeld\trollxd\troll;

use pocketmine\player\Player;

interface TrollRequirement
{
	public function isSatisfied(Player $target): bool;

	public function getReason(): string;
}
