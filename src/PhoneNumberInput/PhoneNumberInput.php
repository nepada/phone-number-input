<?php
declare(strict_types = 1);

namespace Nepada\PhoneNumberInput;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Brick\PhoneNumber\PhoneNumberParseException;
use Nette\Forms\Controls\TextInput;
use Nette\Forms\Form;
use Nette\Forms\Validator as NetteFormsValidator;
use Nette\Utils\Html;
use Nette\Utils\Strings;

class PhoneNumberInput extends TextInput
{

    public const VALID = Validator::class . '::validatePhoneNumber';
    public const VALID_STRICT = Validator::class . '::validatePhoneNumberStrict';
    public const REGION = Validator::class . '::validatePhoneNumberRegion';

    private const PHONE_NUMBER_REGEX = '[\s\d()\[\]~/.+-]+';

    private ?string $defaultRegionCode = null;

    /**
     * @param string|Html<mixed>|null $label
     * @param string|null $defaultRegionCode
     */
    public function __construct($label = null, ?string $defaultRegionCode = null)
    {
        parent::__construct($label);
        $this->defaultRegionCode = $defaultRegionCode;
        $this->setHtmlType('tel');
        $this->setNullable();
        $invalidValueErrorMessage = NetteFormsValidator::$messages[self::VALID] ?? 'Please enter a valid phone number.';
        $this->addRule(Form::PATTERN, $invalidValueErrorMessage, self::PHONE_NUMBER_REGEX);
        $this->addRule(self::VALID, $invalidValueErrorMessage);
    }

    public function getDefaultRegionCode(): ?string
    {
        return $this->defaultRegionCode;
    }

    public function setDefaultRegionCode(?string $defaultRegionCode): void
    {
        $this->defaultRegionCode = $defaultRegionCode;
    }

    public function getValue(): ?PhoneNumber
    {
        /** @var PhoneNumber|null $value */
        $value = parent::getValue();
        return $value;
    }

    /**
     * @internal
     * @param mixed $value
     * @return static
     */
    public function setValue($value): self
    {
        if ($value === null) {
            $this->value = '';
            $this->rawValue = '';
            return $this;
        }

        if (is_string($value)) {
            $value = PhoneNumber::parse($value, $this->defaultRegionCode);
        } elseif (! $value instanceof PhoneNumber) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Value must be null, PhoneNumber instance, or string with a valid phone number, %s given in field "%s".',
                    gettype($value),
                    $this->name,
                ),
            );
        }

        $this->value = $value;
        $this->rawValue = ($this->defaultRegionCode !== null && $this->defaultRegionCode === $value->getRegionCode())
            ? $value->format(PhoneNumberFormat::NATIONAL)
            : $value->format(PhoneNumberFormat::INTERNATIONAL);
        return $this;
    }

    /**
     * @param PhoneNumber|string|null $value
     * @return static
     */
    public function setDefaultValue($value): self
    {
        parent::setDefaultValue($value);
        return $this;
    }

    public function loadHttpData(): void
    {
        $value = $this->getHttpData(Form::DATA_LINE);

        if ($value === '' || $value === Strings::trim($this->translate($this->emptyValue))) {
            $this->value = '';
            $this->rawValue = $value;
            return;
        }

        try {
            $this->setValue($value);
            $this->rawValue = $value;
        } catch (PhoneNumberParseException $exception) {
            $this->value = '';
            $this->rawValue = $value;
        }
    }

    public function isFilled(): bool
    {
        return $this->rawValue !== '' && $this->rawValue !== Strings::trim($this->translate($this->emptyValue));
    }

    /**
     * @return Html<mixed>
     */
    public function getControl(): Html
    {
        $control = parent::getControl();
        if ($this->defaultRegionCode !== null) {
            $control->data('default-region-code', $this->defaultRegionCode);
        }

        return $control;
    }

}
