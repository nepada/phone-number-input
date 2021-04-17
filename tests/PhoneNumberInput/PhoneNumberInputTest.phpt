<?php
declare(strict_types = 1);

namespace NepadaTests\PhoneNumberInput;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberParseException;
use Nepada\PhoneNumberInput\PhoneNumberInput;
use NepadaTests\TestCase;
use Nette\Forms\Form;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


/**
 * @testCase
 */
class PhoneNumberInputTest extends TestCase
{

    private const PATTERN = '[\s\d()\[\]~/.+-]+';
    private const RULE_PATTERN = '{"op":":pattern","msg":"Please enter a valid phone number.","arg":"[\\\\s\\\\d()\\\\[\\\\]~/.+-]+"}';
    private const RULE_VALID = '{"op":"Nepada\\\\PhoneNumberInput\\\\Validator::validatePhoneNumber","msg":"Please enter a valid phone number."}';
    private const RULE_REQUIRED = '{"op":":filled","msg":"true"},';

    public function testDefaultRegionCode(): void
    {
        $input = new PhoneNumberInput('Phone');
        Assert::null($input->getDefaultRegionCode());
        $input->setDefaultRegionCode('CZ');
        Assert::same('CZ', $input->getDefaultRegionCode());

        $input = new PhoneNumberInput('Phone', 'US');
        Assert::same('US', $input->getDefaultRegionCode());
        $input->setDefaultRegionCode(null);
        Assert::null($input->getDefaultRegionCode());
    }

    public function testRenderingWithDefaultRegionCode(): void
    {
        $form = new Form();
        $phoneInput = new PhoneNumberInput('Phone', 'CZ');
        $form['phone'] = $phoneInput;

        $phoneInput->setValue('+420212345678');
        Assert::same(
            '<input type="tel" name="phone" pattern="' . self::PATTERN . '" id="frm-phone" '
            . 'data-nette-rules=\'[' . self::RULE_PATTERN . ',' . self::RULE_VALID . ']\' '
            . 'value="212 345 678" data-default-region-code="CZ">',
            (string) $phoneInput->getControl(),
        );

        $phoneInput->setValue('+12015550123');
        Assert::same(
            '<input type="tel" name="phone" pattern="' . self::PATTERN . '" id="frm-phone" '
            . 'data-nette-rules=\'[' . self::RULE_PATTERN . ',' . self::RULE_VALID . ']\' '
            . 'value="+1 201-555-0123" data-default-region-code="CZ">',
            (string) $phoneInput->getControl(),
        );
    }

    public function testRenderingWithoutDefaultRegionCode(): void
    {
        $form = new Form();
        $phoneInput = new PhoneNumberInput('Phone');
        $phoneInput->setRequired(false);
        $form['phone'] = $phoneInput;

        $phoneInput->setValue('+420212345678');
        Assert::same(
            '<input type="tel" name="phone" pattern="' . self::PATTERN . '" id="frm-phone" '
            . 'data-nette-rules=\'[' . self::RULE_PATTERN . ',' . self::RULE_VALID . ']\' '
            . 'value="+420 212 345 678">',
            (string) $phoneInput->getControl(),
        );

        $phoneInput->setValue('+12015550123');
        Assert::same(
            '<input type="tel" name="phone" pattern="' . self::PATTERN . '" id="frm-phone" '
            . 'data-nette-rules=\'[' . self::RULE_PATTERN . ',' . self::RULE_VALID . ']\' '
            . 'value="+1 201-555-0123">',
            (string) $phoneInput->getControl(),
        );
    }

    public function testSetNullValue(): void
    {
        $input = new PhoneNumberInput();
        $input->setValue(null);
        Assert::null($input->getValue());
    }

    public function testSetPhoneNumberValue(): void
    {
        $phoneNumber = PhoneNumber::parse('+420212345678');
        $input = new PhoneNumberInput();
        $input->setValue($phoneNumber);
        Assert::type(PhoneNumber::class, $input->getValue());
        Assert::same((string) $phoneNumber, (string) $input->getValue());
    }

    public function testSetValidStringValue(): void
    {
        $phoneNumber = '+420 212 34 56 78';
        $input = new PhoneNumberInput();
        $input->setValue($phoneNumber);
        Assert::type(PhoneNumber::class, $input->getValue());
        Assert::same('+420212345678', (string) $input->getValue());
    }

    public function testSetValidStringNationalNumberValue(): void
    {
        $phoneNumber = '212 345 678';
        $input = new PhoneNumberInput();
        $input->setDefaultRegionCode('CZ');
        $input->setValue($phoneNumber);
        Assert::type(PhoneNumber::class, $input->getValue());
        Assert::same('+420212345678', (string) $input->getValue());
    }

    public function testSetInvalidStringValue(): void
    {
        $input = new PhoneNumberInput();
        Assert::exception(
            function () use ($input): void {
                $input->setValue('123');
            },
            PhoneNumberParseException::class,
        );
    }

    public function testSetInvalidValue(): void
    {
        $input = new PhoneNumberInput();
        Assert::exception(
            function () use ($input): void {
                $input->setValue(42);
            },
            \InvalidArgumentException::class,
        );
    }

    public function testNoDataSubmitted(): void
    {
        $this->resetHttpGlobalVariables();
        $_POST['phone'] = '';

        $form = $this->createForm();
        $phoneInput = new PhoneNumberInput();
        $form['phone'] = $phoneInput;
        $form->fireEvents();

        Assert::null($phoneInput->getValue());
        Assert::same(null, $phoneInput->getError());
        Assert::same(
            '<input type="tel" name="phone" pattern="' . self::PATTERN . '" id="frm-phone" '
            . 'data-nette-rules=\'[' . self::RULE_PATTERN . ',' . self::RULE_VALID . ']\'>',
            (string) $phoneInput->getControl(),
        );
    }

    public function testEmptyValueSubmitted(): void
    {
        $this->resetHttpGlobalVariables();
        $_POST['phone'] = '+420';

        $form = $this->createForm();
        $phoneInput = new PhoneNumberInput();
        $form['phone'] = $phoneInput;
        $phoneInput->setEmptyValue('+420');
        $form->fireEvents();

        Assert::null($phoneInput->getValue());
        Assert::same(null, $phoneInput->getError());
        Assert::same(
            '<input type="tel" name="phone" pattern="' . self::PATTERN . '" id="frm-phone" '
            . 'data-nette-rules=\'[' . self::RULE_PATTERN . ',' . self::RULE_VALID . ']\' '
            . 'data-nette-empty-value="+420" value="+420">',
            (string) $phoneInput->getControl(),
        );
    }

    public function testValidDataSubmitted(): void
    {
        $this->resetHttpGlobalVariables();
        $_POST['phone'] = '+420 212 34 56 78';

        $form = $this->createForm();
        $phoneInput = new PhoneNumberInput();
        $form['phone'] = $phoneInput;
        $form->fireEvents();

        Assert::type(PhoneNumber::class, $phoneInput->getValue());
        Assert::same('+420212345678', (string) $phoneInput->getValue());
        Assert::same(null, $phoneInput->getError());
        Assert::same(
            '<input type="tel" name="phone" pattern="' . self::PATTERN . '" id="frm-phone" '
            . 'data-nette-rules=\'[' . self::RULE_PATTERN . ',' . self::RULE_VALID . ']\' '
            . 'value="+420 212 34 56 78">',
            (string) $phoneInput->getControl(),
        );
    }

    public function testInvalidDataSubmitted(): void
    {
        $this->resetHttpGlobalVariables();
        $_POST['phone'] = '123';

        $form = $this->createForm();
        $phoneInput = new PhoneNumberInput();
        $form['phone'] = $phoneInput;
        $phoneInput->setRequired('true');
        $form->fireEvents();

        Assert::null($phoneInput->getValue());
        Assert::same('Please enter a valid phone number.', $phoneInput->getError());
        Assert::same(
            '<input type="tel" name="phone" pattern="' . self::PATTERN . '" id="frm-phone" required '
            . 'data-nette-rules=\'[' . self::RULE_REQUIRED . self::RULE_PATTERN . ',' . self::RULE_VALID . ']\' '
            . 'value="123">',
            (string) $phoneInput->getControl(),
        );
    }

    private function resetHttpGlobalVariables(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_FILES = [];
        $_COOKIE['_nss'] = '1';
        $_POST = [];
        $_GET = [];
    }

    private function createForm(): Form
    {
        $form = new Form();
        $form->onSubmit[] = function (): void {
        };
        return $form;
    }

}


(new PhoneNumberInputTest())->run();
