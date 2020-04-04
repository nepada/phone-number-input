<?php
declare(strict_types = 1);

namespace Nepada\Bridges\PhoneNumberInputForms;

use Nepada\PhoneNumberInput\PhoneNumberInput;
use Nette;
use Nette\Forms\Container;

class ExtensionMethodRegistrator
{

    use Nette\StaticClass;

    public static function register(): void
    {
        Container::extensionMethod(
            'addPhoneNumber',
            fn (Container $container, $name, $label = null, ?string $defaultRegionCode = null): PhoneNumberInput => $container[$name] = new PhoneNumberInput($label, $defaultRegionCode),
        );
    }

}
