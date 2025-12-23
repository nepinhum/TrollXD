<?php

declare(strict_types=1);

namespace hazeld\trollxd\troll\value;

use InvalidArgumentException;

final class BooleanTrollValue extends TrollValue
{
	public function __construct(string $name, bool $value, ?string $label = null)
	{
		parent::__construct($name, $value, $label);
	}

	public function getValue(): bool
	{
		return parent::getValue();
	}

	protected function assertValue(mixed $value): void
	{
		if (!is_bool($value)) {
			throw new InvalidArgumentException("Value for '{$this->getName()}' must be a boolean.");
		}
	}
}
