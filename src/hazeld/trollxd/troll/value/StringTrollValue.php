<?php

declare(strict_types=1);

namespace hazeld\trollxd\troll\value;

use InvalidArgumentException;

final class StringTrollValue extends TrollValue
{
	private ?int $minLength;
	private ?int $maxLength;

	public function __construct(string $name, string $value, ?int $minLength = null, ?int $maxLength = null, ?string $label = null)
	{
		$this->minLength = $minLength;
		$this->maxLength = $maxLength;
		parent::__construct($name, $value, $label);
	}

	public function getValue(): string
	{
		return parent::getValue();
	}

	protected function assertValue(mixed $value): void
	{
		if (!is_string($value)) {
			throw new InvalidArgumentException("Value for '{$this->getName()}' must be a string.");
		}

		$length = strlen($value);
		if ($this->minLength !== null && $length < $this->minLength) {
			throw new InvalidArgumentException("Value for '{$this->getName()}' must be at least {$this->minLength} characters.");
		}

		if ($this->maxLength !== null && $length > $this->maxLength) {
			throw new InvalidArgumentException("Value for '{$this->getName()}' must be at most {$this->maxLength} characters.");
		}
	}
}
