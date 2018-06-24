<?php
declare(strict_types = 1);

namespace NepadaTests\Bridges\PhoneNumberInputForms;

use Nepada\PhoneNumberInput\PhoneNumberInput;
use NepadaTests\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';


/**
 * @testCase
 */
class TPhoneNumberInputTest extends TestCase
{

    public function testInternationalPhoneNumberInput(): void
    {
        $form = new TestForm();
        $input = $form->addPhoneNumber('test', 'Phone');
        Assert::type(PhoneNumberInput::class, $input);
        Assert::same('Phone', $input->caption);
        Assert::same(null, $input->getDefaultRegionCode());
        Assert::same($input, $form['test']);
    }

    public function testRegionalPhoneNumberInput(): void
    {
        $form = new TestForm();
        $input = $form->addPhoneNumber('test', 'CZ phone', 'CZ');
        Assert::type(PhoneNumberInput::class, $input);
        Assert::same('CZ phone', $input->caption);
        Assert::same('CZ', $input->getDefaultRegionCode());
        Assert::same($input, $form['test']);
    }

}

(new TPhoneNumberInputTest())->run();
