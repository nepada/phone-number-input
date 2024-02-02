<?php
declare(strict_types = 1);

namespace Nepada\Bridges\PhoneNumberInputForms;

use Nepada\PhoneNumberInput\PhoneNumberInput;
use Nette;
use Nette\Forms\Container;
use Nette\Utils\Html;

class ExtensionMethodRegistrator
{

    use Nette\StaticClass;

    public static function register(): void
    {
        Container::extensionMethod(
            'addPhoneNumber',
            fn (Container $container, string|int $name, string|Html|null $label = null, ?string $defaultRegionCode = null): PhoneNumberInput => $container[(string) $name] = new PhoneNumberInput($label, $defaultRegionCode),
        );
    }

}
