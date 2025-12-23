<?php

declare(strict_types=1);

namespace hazeld\trollxd\troll;

use hazeld\trollxd\troll\traits\TrollRequirementsTrait;
use hazeld\trollxd\troll\value\TrollValue;
use InvalidArgumentException;
use pocketmine\player\Player;

/**
 * Base class every troll implementation should extend.
 * Handles value registration and requirement checks so individual trolls
 * can focus on their behaviour.
 */
abstract class Troll
{
	use TrollRequirementsTrait;

	private string $name;
	private string $description;

	/** @var array<string, TrollValue> */
	private array $values = [];

	public function __construct(string $name, string $description = "")
	{
		$this->name = $name;
		$this->description = $description;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * Registers a value for this troll.
	 *
	 * @throws InvalidArgumentException when a value with the same name already exists
	 */
	public function registerValue(TrollValue $value): TrollValue
	{
		$key = strtolower($value->getName());
		if (isset($this->values[$key])) {
			throw new InvalidArgumentException("Troll value '{$value->getName()}' already registered for {$this->name}");
		}

		$this->values[$key] = $value;
		return $value;
	}

	public function hasValue(string $name): bool
	{
		return isset($this->values[strtolower($name)]);
	}

	/**
	 * @return TrollValue|null
	 */
	public function getValue(string $name)
	{
		return $this->values[strtolower($name)] ?? null;
	}

	/**
	 * @return TrollValue[]
	 */
	public function getValues(): array
	{
		return array_values($this->values);
	}

	/**
	 * Execute the troll after requirement validation.
	 *
	 * @return bool false when requirements are not satisfied
	 */
	final public function execute(Player $target): bool
	{
		if (!$this->requirementsMet($target)) {
			return false;
		}

		$this->onExecute($target);
		return true;
	}

	abstract protected function onExecute(Player $target): void;
}
