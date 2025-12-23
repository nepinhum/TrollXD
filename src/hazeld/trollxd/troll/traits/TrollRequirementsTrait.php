<?php

declare(strict_types=1);

namespace hazeld\trollxd\troll\traits;

use hazeld\trollxd\troll\TrollRequirement;
use pocketmine\player\Player;

trait TrollRequirementsTrait
{
	/** @var TrollRequirement[] */
	private array $requirements = [];

	public function addRequirement(TrollRequirement $requirement): void
	{
		$this->requirements[] = $requirement;
	}

	public function clearRequirements(): void
	{
		$this->requirements = [];
	}

	public function requirementsMet(Player $target): bool
	{
		return $this->getRequirementErrors($target) === [];
	}

	/**
	 * @return string[]
	 */
	public function getRequirementErrors(Player $target): array
	{
		$errors = [];
		foreach ($this->getRequirements() as $requirement) {
			if (!$requirement->isSatisfied($target)) {
				$errors[] = $requirement->getReason();
			}
		}

		return $errors;
	}

	/**
	 * @return TrollRequirement[]
	 */
	private function getRequirements(): array
	{
		$requirements = $this->requirements;
		if ($this instanceof TrollRequirement) {
			$requirements[] = $this;
		}

		return $requirements;
	}
}
