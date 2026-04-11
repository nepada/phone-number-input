<?php
declare(strict_types = 1);

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;

$config = ['parameters' => ['ignoreErrors' => []]];

if (! InstalledVersions::satisfies(new VersionParser(), 'nette/forms', '<=3.2.8')) {
    $config['parameters']['ignoreErrors'][] = [
        'message' => '~^Parameter \\#2 \\$callback of static method Nette\\\\Forms\\\\Container\\:\\:extensionMethod\\(\\) expects callable\\(Nette\\\\Forms\\\\Container\\)\\: mixed, Closure\\(Nette\\\\Forms\\\\Container, int\\|string, Nette\\\\Utils\\\\Html\\|string\\|null\\=, string\\|null\\=\\)\\: Nepada\\\\PhoneNumberInput\\\\PhoneNumberInput given\\.$~',
        'path' => __DIR__ . '/../../src/Bridges/PhoneNumberInputForms/ExtensionMethodRegistrator.php',
        'count' => 1,
    ];
}

return $config;
