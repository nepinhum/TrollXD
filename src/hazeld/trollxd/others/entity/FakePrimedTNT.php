<?php

declare(strict_types=1);

namespace hazeld\trollxd\others\entity;

use pocketmine\entity\object\PrimedTNT;
use pocketmine\event\entity\EntityPreExplodeEvent;
use pocketmine\world\Explosion;
use pocketmine\world\Position;

final class FakePrimedTNT extends PrimedTNT
{
	// explodeA removed but still causes to damage
	public function explode(): void
	{
		$ev = new EntityPreExplodeEvent($this, 4);
		$ev->call();

		if(!$ev->isCancelled())
		{
			$explosion = new Explosion(Position::fromObject($this->location->add(0, $this->size->getHeight() / 2, 0), $this->getWorld()), $ev->getRadius(), $this);
			$explosion->explodeB();
		}
	}
}
