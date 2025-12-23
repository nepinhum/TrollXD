<?php

declare(strict_types=1);

namespace hazeld\trollxd\utils;

use hazeld\trollxd\Loader;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;
use wr3p\i18ntl\TL;

final class Translator
{
	use SingletonTrait;

	private TL $tl;
	private string $targetLanguage = "en_US";

	public function init(Loader $instance): void
	{
		$targetLanguage = $instance->getPluginConfig()->getDefaultLanguage();
		$this->tl = new TL();
		$this->tl->init($targetLanguage);
		$this->tl->addProject("trollxd", $instance->getResourceFolder() . "locale-data");
	}

	public function getTl(): TL
	{
		return $this->tl;
	}

	public function translate(string $key, array $args = [])
	{
		return $this->colorize($this->tl->translate("trollxd", $this->targetLanguage, $key, $args));
	}

	private function colorize(string $text): string
	{
		return TextFormat::colorize($text);
	}
}
