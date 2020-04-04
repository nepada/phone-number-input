<?php
declare(strict_types = 1);

namespace NepadaTests\Bridges\PhoneNumberInputForms;

use Nepada\Bridges\PhoneNumberInputForms\PhoneNumberInputMixin;
use Nette;

class TestForm extends Nette\Forms\Form
{

    use PhoneNumberInputMixin;

}
