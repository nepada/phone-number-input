<?php
declare(strict_types = 1);

namespace Nepada\PhoneNumberInput;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberParseException;
use Nette;
use Nette\Forms\Control;
use function is_array;

final class Validator
{

    use Nette\StaticClass;

    /**
     * Does the control value look like a phone number?
     * This performs only basic checks (e.g. of the length of the number). For a more strict validation use `validatePhoneNumberStrict()`.
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
     */
    public static function validatePhoneNumberStrict(Control $control): bool
    {
        $value = self::castToPhoneNumber($control->getValue());
        return $value instanceof PhoneNumber && $value->isValidNumber();
    }

    /**
     * Does the control value contain a phone number from one of the specified regions?
     *
     * @param string|string[] $allowedRegionCodes
     */
    public static function validatePhoneNumberRegion(Control $control, string|array $allowedRegionCodes): bool
    {
        $allowedRegionCodes = is_array($allowedRegionCodes) ? $allowedRegionCodes : [$allowedRegionCodes];
        $value = self::castToPhoneNumber($control->getValue());
        return $value instanceof PhoneNumber && in_array($value->getRegionCode(), $allowedRegionCodes, true);
    }

    private static function castToPhoneNumber(mixed $value): ?PhoneNumber
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
