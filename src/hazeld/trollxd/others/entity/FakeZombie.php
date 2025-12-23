<?php

declare(strict_types=1);

namespace hazeld\trollxd\others\entity;

use pocketmine\entity\Zombie;
use pocketmine\event\entity\EntityDamageEvent;

final class FakeZombie extends Zombie
{
	public function attack(EntityDamageEvent $source): void
	{
		$source->cancel();
	}
}
