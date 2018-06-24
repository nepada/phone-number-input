<?php
declare(strict_types = 1);

namespace Nepada\Bridges\PhoneNumberInputForms;

use Nepada\PhoneNumberInput\PhoneNumberInput;
use Nette\Utils\Html;

trait TPhoneNumberInput
{

    /**
     * @param string|int $name
     * @param string|Html|null $label
     * @param string|null $defaultRegionCode
     * @return PhoneNumberInput
     */
    public function addPhoneNumber($name, $label = null, ?string $defaultRegionCode = null): PhoneNumberInput
    {
        return $this[$name] = new PhoneNumberInput($label, $defaultRegionCode);
    }

}
