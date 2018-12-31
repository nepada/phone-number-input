<?php
declare(strict_types = 1);

namespace NepadaTests\PhoneNumberInput;

use Brick\PhoneNumber\PhoneNumber;
use Mockery\MockInterface;
use Nepada\PhoneNumberInput\Validator;
use NepadaTests\TestCase;
use Nette\Forms\IControl;
use Nette\Utils\Html;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


/**
 * @testCase
 */
class ValidatorTest extends TestCase
{

    /**
     * @dataProvider getDataForValidatePhoneNumber
     * @param mixed $value
     * @param bool $isValid
     */
    public function testValidatePhoneNumber($value, bool $isValid): void
    {
        $control = $this->mockControl($value);
        Assert::same($isValid, Validator::validatePhoneNumber($control));
    }

    /**
     * @return mixed[]
     */
    protected function getDataForValidatePhoneNumber(): array
    {
        return [
            [
                'value' => ['+420212345678'],
                'isValid' => false,
            ],
            [
                'value' => 3.1415,
                'isValid' => false,
            ],
            [
                'value' => null,
                'isValid' => false,
            ],
            [
                'value' => '',
                'isValid' => false,
            ],
            [
                'value' => '+420212345678',
                'isValid' => true,
            ],
            [
                'value' => Html::el()->setText('+420212345678'),
                'isValid' => true,
            ],
            [
                'value' => PhoneNumber::parse('+420212345678'),
                'isValid' => true,
            ],
            [
                'value' => PhoneNumber::parse('+420111111111'),
                'isValid' => true,
            ],
            [
                'value' => PhoneNumber::parse('+42012'),
                'isValid' => false,
            ],
        ];
    }

    /**
     * @dataProvider getDataForValidatePhoneNumberStrict
     * @param mixed $value
     * @param bool $isValid
     */
    public function testValidatePhoneNumberStrict($value, bool $isValid): void
    {
        $control = $this->mockControl($value);
        Assert::same($isValid, Validator::validatePhoneNumberStrict($control));
    }

    /**
     * @return mixed[]
     */
    protected function getDataForValidatePhoneNumberStrict(): array
    {
        return [
            [
                'value' => ['+420212345678'],
                'isValid' => false,
            ],
            [
                'value' => 3.1415,
                'isValid' => false,
            ],
            [
                'value' => null,
                'isValid' => false,
            ],
            [
                'value' => '',
                'isValid' => false,
            ],
            [
                'value' => '+420212345678',
                'isValid' => true,
            ],
            [
                'value' => Html::el()->setText('+420212345678'),
                'isValid' => true,
            ],
            [
                'value' => PhoneNumber::parse('+420212345678'),
                'isValid' => true,
            ],
            [
                'value' => PhoneNumber::parse('+420111111111'),
                'isValid' => false,
            ],
            [
                'value' => PhoneNumber::parse('+42012'),
                'isValid' => false,
            ],
        ];
    }

    /**
     * @dataProvider getDataForValidatePhoneNumberRegion
     * @param mixed $value
     * @param string|string[] $regions
     * @param bool $isValid
     */
    public function testValidatePhoneNumberRegion($value, $regions, bool $isValid): void
    {
        $control = $this->mockControl($value);
        Assert::same($isValid, Validator::validatePhoneNumberRegion($control, $regions));
    }

    /**
     * @return mixed[]
     */
    protected function getDataForValidatePhoneNumberRegion(): array
    {
        return [
            [
                'value' => null,
                'regions' => 'CZ',
                'isValid' => false,
            ],
            [
                'value' => '+420212345678',
                'regions' => 'CZ',
                'isValid' => true,
            ],
            [
                'value' => Html::el()->setText('+420212345678'),
                'regions' => ['CZ'],
                'isValid' => true,
            ],
            [
                'value' => PhoneNumber::parse('+420212345678'),
                'regions' => ['US', 'CZ'],
                'isValid' => true,
            ],
            [
                'value' => PhoneNumber::parse('+420212345678'),
                'regions' => ['US', 'DE'],
                'isValid' => false,
            ],
        ];
    }

    /**
     * @param mixed $value
     * @return IControl|MockInterface
     */
    private function mockControl($value): IControl
    {
        $control = \Mockery::mock(IControl::class);
        $control->shouldReceive('getValue')->andReturn($value);
        return $control;
    }

}


(new ValidatorTest())->run();
