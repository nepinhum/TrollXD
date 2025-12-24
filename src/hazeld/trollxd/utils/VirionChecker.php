<?php

declare(strict_types=1);

namespace hazeld\trollxd\utils;

use dktapps\pmforms\MenuForm;
use hazeld\trollxd\Loader;
use wr3p\i18ntl\TL;

final class VirionChecker
{
	public static function checkVirions(Loader $instance): bool
	{
		$required = [
			"TranslationManager" => TL::class,
			"pmforms" => MenuForm::class,
		];

		foreach ($required as $name => $class) {
			if (!class_exists($class)) {
				$instance->getLogger()->error("§cMissing virion: §4{$name}");
				$instance->getLogger()->error("§7Class required: §f{$class}");
				return false;
			}

			$instance->getLogger()->debug("Virion loaded: {$name}");
		}

		return true;
	}
}
