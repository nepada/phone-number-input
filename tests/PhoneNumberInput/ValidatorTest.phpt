<?php
declare(strict_types = 1);

namespace NepadaTests\PhoneNumberInput;

use Brick\PhoneNumber\PhoneNumber;
use Mockery\MockInterface;
use Nepada\PhoneNumberInput\Validator;
use NepadaTests\TestCase;
use Nette\Forms\Control;
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
     */
    public function testValidatePhoneNumber(mixed $value, bool $isValid): void
    {
        $control = $this->mockControl($value);
        Assert::same($isValid, Validator::validatePhoneNumber($control));
    }

    /**
     * @return list<mixed[]>
     */
    protected function getDataForValidatePhoneNumber(): array
    {
        return [
            [
                'value' => ['+420212345678'],
                'isValid' => false,
            ],
            [
                'value' => 3.14,
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
     */
    public function testValidatePhoneNumberStrict(mixed $value, bool $isValid): void
    {
        $control = $this->mockControl($value);
        Assert::same($isValid, Validator::validatePhoneNumberStrict($control));
    }

    /**
     * @return list<mixed[]>
     */
    protected function getDataForValidatePhoneNumberStrict(): array
    {
        return [
            [
                'value' => ['+420212345678'],
                'isValid' => false,
            ],
            [
                'value' => 3.14,
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
     * @param string|string[] $regions
     */
    public function testValidatePhoneNumberRegion(mixed $value, string|array $regions, bool $isValid): void
    {
        $control = $this->mockControl($value);
        Assert::same($isValid, Validator::validatePhoneNumberRegion($control, $regions));
    }

    /**
     * @return list<mixed[]>
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
     * @return Control&MockInterface
     */
    private function mockControl(mixed $value): Control
    {
        $control = \Mockery::mock(Control::class);
        $control->shouldReceive('getValue')->andReturn($value);
        return $control;
    }

}


(new ValidatorTest())->run();
