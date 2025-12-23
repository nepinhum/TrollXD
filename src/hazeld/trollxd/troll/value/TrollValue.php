<?php

declare(strict_types=1);

namespace hazeld\trollxd\troll\value;

use InvalidArgumentException;

abstract class TrollValue
{
	private string $name;
	private string $label;
	protected mixed $value;

	public function __construct(string $name, mixed $value, ?string $label = null)
	{
		$this->name = $name;
		$this->label = $label ?? $name;
		$this->setValue($value);
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getLabel(): string
	{
		return $this->label;
	}

	public function getType(): string
	{
		return static::class;
	}

	public function setValue(mixed $value): void
	{
		$this->assertValue($value);
		$this->value = $value;
	}

	public function getValue(): mixed
	{
		return $this->value;
	}

	/**
	 * @throws InvalidArgumentException when the provided value is invalid
	 */
	abstract protected function assertValue(mixed $value): void;
}
