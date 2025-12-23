<?php

declare(strict_types=1);

namespace hazeld\trollxd\troll\value;

use InvalidArgumentException;

final class IntegerTrollValue extends TrollValue
{
	private ?int $min;
	private ?int $max;

	public function __construct(string $name, int $value, ?int $min = null, ?int $max = null, ?string $label = null)
	{
		$this->min = $min;
		$this->max = $max;
		parent::__construct($name, $value, $label);
	}

	public function getValue(): int
	{
		return parent::getValue();
	}

	protected function assertValue(mixed $value): void
	{
		if (!is_int($value)) {
			throw new InvalidArgumentException("Value for '{$this->getName()}' must be an integer.");
		}

		if ($this->min !== null && $value < $this->min) {
			throw new InvalidArgumentException("Value for '{$this->getName()}' must be >= {$this->min}.");
		}

		if ($this->max !== null && $value > $this->max) {
			throw new InvalidArgumentException("Value for '{$this->getName()}' must be <= {$this->max}.");
		}
	}
}
