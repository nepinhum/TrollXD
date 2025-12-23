<?php

declare(strict_types=1);

namespace hazeld\trollxd\troll\value;

use InvalidArgumentException;

final class FloatTrollValue extends TrollValue
{
	private ?float $min;
	private ?float $max;

	public function __construct(string $name, float $value, ?float $min = null, ?float $max = null, ?string $label = null)
	{
		$this->min = $min;
		$this->max = $max;
		parent::__construct($name, $value, $label);
	}

	public function getValue(): float
	{
		return parent::getValue();
	}

	protected function assertValue(mixed $value): void
	{
		if (!is_float($value) && !is_int($value)) { // ints accepted for convenience
			throw new InvalidArgumentException("Value for '{$this->getName()}' must be numeric.");
		}

		$value = (float)$value;
		if ($this->min !== null && $value < $this->min) {
			throw new InvalidArgumentException("Value for '{$this->getName()}' must be >= {$this->min}.");
		}

		if ($this->max !== null && $value > $this->max) {
			throw new InvalidArgumentException("Value for '{$this->getName()}' must be <= {$this->max}.");
		}
	}
}
