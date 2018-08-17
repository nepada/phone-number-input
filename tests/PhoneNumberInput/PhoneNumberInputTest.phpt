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

    public function testRenderedValue(): void
    {
        $form = new Form();
        $phoneInput = new PhoneNumberInput('Phone', 'CZ');
        $form['phone'] = $phoneInput;

        $phoneInput->setValue('+420212345678');
        Assert::same('212 345 678', $phoneInput->getControl()->value);

        $phoneInput->setValue('+12015550123');
        Assert::same('+1 201-555-0123', $phoneInput->getControl()->value);
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
            PhoneNumberParseException::class
        );
    }

    public function testSetInvalidValue(): void
    {
        $input = new PhoneNumberInput();
        Assert::exception(
            function () use ($input): void {
                $input->setValue(42);
            },
            \InvalidArgumentException::class
        );
    }

    public function testNoDataSubmitted(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_FILES = [];
        $_POST = ['phone' => ''];

        $form = new Form();
        $phoneInput = new PhoneNumberInput();
        $form['phone'] = $phoneInput;
        $form->fireEvents();

        Assert::null($phoneInput->getValue());
        Assert::same(null, $phoneInput->getError());
        Assert::same(
            '<input type="tel" name="phone" id="frm-phone" data-nette-rules=\''
            . '[{"op":"optional"},{"op":"Nepada\\\\PhoneNumberInput\\\\Validator::validatePhoneNumber","msg":"Please enter a valid phone number."}]'
            . '\'>',
            (string) $phoneInput->getControl()
        );
    }

    public function testEmptyValueSubmitted(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_FILES = [];
        $_POST = ['phone' => '+420'];

        $form = new Form();
        $phoneInput = new PhoneNumberInput();
        $form['phone'] = $phoneInput;
        $phoneInput->setEmptyValue('+420');
        $form->fireEvents();

        Assert::null($phoneInput->getValue());
        Assert::same(null, $phoneInput->getError());
        Assert::same(
            '<input type="tel" name="phone" id="frm-phone" data-nette-rules=\''
            . '[{"op":"optional"},{"op":"Nepada\\\\PhoneNumberInput\\\\Validator::validatePhoneNumber","msg":"Please enter a valid phone number."}]'
            . '\' data-nette-empty-value="+420" value="+420">',
            (string) $phoneInput->getControl()
        );
    }

    public function testValidDataSubmitted(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_FILES = [];
        $_POST = ['phone' => '+420 212 345 678'];

        $form = new Form();
        $phoneInput = new PhoneNumberInput();
        $form['phone'] = $phoneInput;
        $form->fireEvents();

        Assert::type(PhoneNumber::class, $phoneInput->getValue());
        Assert::same('+420212345678', (string) $phoneInput->getValue());
        Assert::same(null, $phoneInput->getError());
        Assert::same(
            '<input type="tel" name="phone" id="frm-phone" data-nette-rules=\''
            . '[{"op":"optional"},{"op":"Nepada\\\\PhoneNumberInput\\\\Validator::validatePhoneNumber","msg":"Please enter a valid phone number."}]'
            . '\' value="+420 212 345 678">',
            (string) $phoneInput->getControl()
        );
    }

    public function testInvalidDataSubmitted(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_FILES = [];
        $_POST = ['phone' => '123'];

        $form = new Form();
        $phoneInput = new PhoneNumberInput();
        $form['phone'] = $phoneInput;
        $phoneInput->setRequired('true');
        $form->fireEvents();

        Assert::null($phoneInput->getValue());
        Assert::same('Please enter a valid phone number.', $phoneInput->getError());
        Assert::same(
            '<input type="tel" name="phone" id="frm-phone" required data-nette-rules=\''
            . '[{"op":":filled","msg":"true"},{"op":"Nepada\\\\PhoneNumberInput\\\\Validator::validatePhoneNumber","msg":"Please enter a valid phone number."}]'
            . '\' value="123">',
            (string) $phoneInput->getControl()
        );
    }

}


(new PhoneNumberInputTest())->run();
