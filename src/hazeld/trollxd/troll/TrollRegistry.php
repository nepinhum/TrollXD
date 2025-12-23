<?php

declare(strict_types=1);

namespace hazeld\trollxd\troll;

use InvalidArgumentException;

final class TrollRegistry
{
	/** @var array<string, Troll> */
	private array $trolls = [];

	public function register(Troll $troll): void
	{
		$key = strtolower($troll->getName());
		if (isset($this->trolls[$key])) {
			throw new InvalidArgumentException("Troll '{$troll->getName()}' already registered");
		}

		$this->trolls[$key] = $troll;
	}

	public function unregister(string $name): void
	{
		unset($this->trolls[strtolower($name)]);
	}

	public function get(string $name): ?Troll
	{
		return $this->trolls[strtolower($name)] ?? null;
	}

	/**
	 * @return Troll[]
	 */
	public function all(): array
	{
		return array_values($this->trolls);
	}
}
