<?php
declare(strict_types = 1);

namespace Nepada\Bridges\PhoneNumberInputForms;

use Nepada\PhoneNumberInput\PhoneNumberInput;
use Nette\Utils\Html;

trait PhoneNumberInputMixin
{

    public function addPhoneNumber(string|int $name, string|Html|null $label = null, ?string $defaultRegionCode = null): PhoneNumberInput
    {
        return $this[$name] = new PhoneNumberInput($label, $defaultRegionCode);
    }

}
