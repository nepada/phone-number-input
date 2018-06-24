<?php
declare(strict_types = 1);

namespace NepadaTests\Bridges\PhoneNumberInputDI;

use Nepada\PhoneNumberInput\PhoneNumberInput;
use NepadaTests\TestCase;
use Nette;
use Nette\Forms\Form;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';


/**
 * @testCase
 */
class PhoneNumberInputExtensionTest extends TestCase
{

    protected function setUp(): void
    {
        $configurator = new Nette\Configurator();
        $configurator->setTempDirectory(TEMP_DIR);
        $configurator->setDebugMode(true);
        $configurator->addConfig(__DIR__ . '/fixtures/config.neon');
        $configurator->createContainer();
    }

    public function testInternationalPhoneNumberInput(): void
    {
        $form = new Form();
        /** @var PhoneNumberInput $input */
        $input = $form->addPhoneNumber('test', 'Phone');
        Assert::type(PhoneNumberInput::class, $input);
        Assert::same('Phone', $input->caption);
        Assert::same(null, $input->getDefaultRegionCode());
        Assert::same($input, $form['test']);
    }

    public function testRegionalPhoneNumberInput(): void
    {
        $form = new Form();
        /** @var PhoneNumberInput $input */
        $input = $form->addPhoneNumber('test', 'CZ phone', 'CZ');
        Assert::type(PhoneNumberInput::class, $input);
        Assert::same('CZ phone', $input->caption);
        Assert::same('CZ', $input->getDefaultRegionCode());
        Assert::same($input, $form['test']);
    }

}


(new PhoneNumberInputExtensionTest())->run();
