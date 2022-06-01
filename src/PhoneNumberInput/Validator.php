<?php
declare(strict_types = 1);

namespace Nepada\PhoneNumberInput;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberParseException;
use Nette;
use Nette\Forms\Control;

final class Validator
{

    use Nette\StaticClass;

    /**
     * Does the control value look like a phone number?
     * This performs only basic checks (e.g. of the length of the number). For a more strict validation use `validatePhoneNumberStrict()`.
     *
     * @param Control $control
     * @return bool
     */
    public static function validatePhoneNumber(Control $control): bool
    {
        $value = self::castToPhoneNumber($control->getValue());
        return $value instanceof PhoneNumber && $value->isPossibleNumber();
    }

    /**
     * Does the control value match a valid phone number pattern?
     * This relies on up-to-date metadata in `giggsey/libphonenumber-for-php`.
     * This doesn't verify the number is actually in use, which is impossible to tell by just looking at a number itself.
     *
     * @param Control $control
     * @return bool
     */
    public static function validatePhoneNumberStrict(Control $control): bool
    {
        $value = self::castToPhoneNumber($control->getValue());
        return $value instanceof PhoneNumber && $value->isValidNumber();
    }

    /**
     * Does the control value contain a phone number from one of the specified regions?
     *
     * @param Control $control
     * @param string|string[] $allowedRegionCodes
     * @return bool
     */
    public static function validatePhoneNumberRegion(Control $control, $allowedRegionCodes): bool
    {
        $allowedRegionCodes = (array) $allowedRegionCodes;
        $value = self::castToPhoneNumber($control->getValue());
        return $value instanceof PhoneNumber && in_array($value->getRegionCode(), $allowedRegionCodes, true);
    }

    /**
     * @param mixed $value
     * @return PhoneNumber|null
     */
    private static function castToPhoneNumber($value): ?PhoneNumber
    {
        if ($value instanceof PhoneNumber || $value === null) {
            return $value;
        }

        if (is_int($value)) {
            $value = (string) $value;
        } elseif (is_object($value) && method_exists($value, '__toString')) {
            $value = $value->__toString();
        }

        if (! is_string($value)) {
            return null;
        }

        try {
            return PhoneNumber::parse($value);
        } catch (PhoneNumberParseException $exception) {
            return null;
        }
    }

}
