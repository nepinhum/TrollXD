<?php

declare(strict_types=1);

namespace hazeld\trollxd\trolls;

use hazeld\trollxd\troll\Troll;
use hazeld\trollxd\troll\TrollRequirement;
use hazeld\trollxd\troll\value\IntegerTrollValue;
use hazeld\trollxd\utils\Translator;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\player\Player;

final class BlindnessTroll extends Troll implements TrollRequirement
{
	public function __construct()
	{
		parent::__construct("blindness", Translator::getInstance()->translate("trolls.descriptions.blindness"));

		$this->registerValue(new IntegerTrollValue("duration", 10, 1, 120, "Duration (seconds)"));
		$this->registerValue(new IntegerTrollValue("amplifier", 0, 0, 5, "Effect amplifier"));
	}

	protected function onExecute(Player $target): void
	{
		$durationSeconds = $this->getValue("duration")->getValue();
		$amplifier = $this->getValue("amplifier")->getValue();

		$target->getEffects()->add(new EffectInstance(
			VanillaEffects::BLINDNESS(),
			$durationSeconds * 20,
			$amplifier,
			false
		));

		$target->sendMessage(Translator::getInstance()->translate("trolls.messages.blindness"));
	}

	public function isSatisfied(Player $target): bool
	{
		return $target->isAlive();
	}

	public function getReason(): string
	{
		return "Target must be alive to be blinded.";
	}
}
