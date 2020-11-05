Phone number form input
=======================

[![Build Status](https://github.com/nepada/phone-number-input/workflows/CI/badge.svg)](https://github.com/nepada/phone-number-input/actions?query=workflow%3ACI+branch%3Amaster)
[![Coverage Status](https://coveralls.io/repos/github/nepada/phone-number-input/badge.svg?branch=master)](https://coveralls.io/github/nepada/phone-number-input?branch=master)
[![Downloads this Month](https://img.shields.io/packagist/dm/nepada/phone-number-input.svg)](https://packagist.org/packages/nepada/phone-number-input)
[![Latest stable](https://img.shields.io/packagist/v/nepada/phone-number-input.svg)](https://packagist.org/packages/nepada/phone-number-input)


Installation
------------

Via Composer:

```sh
$ composer require nepada/phone-number-input
```

### Option A: install form container extension method via DI extension

```yaml
extensions:
    - Nepada\Bridges\PhoneNumberInputDI\PhoneNumberInputExtension
```

It will register extension method `addPhoneNumber($name, $label = null, ?string $defaultRegionCode = null): PhoneNumberInput` to `Nette\Forms\Container`.


### Option B: use trait in your base form/container class

You can also use `PhoneNumberInputMixin` trait in your base form/container class to add method `addPhoneNumber($name, $label = null, ?string $defaultRegionCode = null): PhoneNumberInput`.

Example:

```php

trait FormControls
{

    use Nepada\Bridges\PhoneNumberInputForms\PhoneNumberInputMixin;

    public function addContainer($name)
    {
        $control = new Container;
        $control->setCurrentGroup($this->getCurrentGroup());
        if ($this->currentGroup !== null) {
            $this->currentGroup->add($control);
        }
        return $this[$name] = $control;
    }

}

class Container extends Nette\Forms\Container
{

    use FormControls;

}

class Form extends Nette\Forms\Form
{

    use FormControls;

}

``` 


Usage
-----

`PhoneNumberInput` is form control that uses phone number value object to represent its value (see [brick/phonenumber](https://github.com/brick/phonenumber) for further details).
It automatically validates the user input and `getValue()` method always returns `PhoneNumber` instance, or `null` if the input is not filled.

```php
$PhoneNumberInput = $form->addPhoneNumber('phone');
$PhoneNumberInput->setValue('invalid'); // \InvalidArgumentException is thrown
$PhoneNumberInput->setValue('+420 212 345 678'); // the value is internally converted to PhoneNumber value object
$PhoneNumberInput->getValue(); // PhoneNumber instance for +420212345678 
```


### Validation

The default validation is fairly lenient - it performs only basic check based on the parsed region and the length of the number.

#### Strict validation

You can add a more strict validation rule `PhoneNumberInput::VALID_STRICT`.
This rule validates the content against regular expressions from metadata database.

**Warning:** you must make sure you've got up-to-date metadata library, otherwise you risk running into false positives and false negatives during the validation.
The metadata are provided by [giggsey/libphonenumber-for-php](https://github.com/giggsey/libphonenumber-for-php) for backend validation and [libphonenumber-js](https://yarnpkg.com/package/libphonenumber-js) for client side validation.

#### Region validation

You can restrict the input to accept only numbers from specific region(s):
```php
// Specify one or more ISO 3166-1 alpha-2 country codes
$input->addRule(PhoneNumberInput::REGION, 'Only US phone numbers are allowed', 'US');
$input->addRule(PhoneNumberInput::REGION, 'Only Czech and Slovak phone numbers are allowed', ['CZ', 'SK']);
```

### Default region code

When creating the input you may specify default region code (ISO 3166-1 alpha-2 country code), e.g. `$form->addPhoneNumber('phone', 'Phone', 'CZ')`. This has two effects:
1) User may omit the country code prefix for this region in the input field, e.g. `212 345 678` is interpreted as `+420 212 345 678`.
2) When rendering the input, phone numbers for this region are displayed in national format instead of international, i.e. the country code is omitted.


### Client side validation

This package comes with client side validation built on top of [libphonenumber-js](https://yarnpkg.com/package/libphonenumber-js). It is published as npm package [@nepada/phone-number-input](https://yarnpkg.com/package/@nepada/phone-number-input).

`libphonenumber-js` provides several [different metadata sets](https://gitlab.com/catamphetamine/libphonenumber-js#customizing-metadata). You should choose the one based on your validation needs (e.g. if you don't need strict validation, go with `min`), or build your own custom metadata set.

#### Using precompiled bundle

Using precompiled bundles is the quick'n'dirty way of getting client side validation to work.

```html
<script src="https://unpkg.com/libphonenumber-js@%5E1.7/bundle/libphonenumber-max.js"></script>
<!--
OR
<script src="https://unpkg.com/libphonenumber-js@%5E1.7/bundle/libphonenumber-min.js"></script>
OR
<script src="https://unpkg.com/libphonenumber-js@%5E1.7/bundle/libphonenumber-mobile.js"></script>
-->
<script src="https://unpkg.com/nette-forms@%5E3.0/src/assets/netteForms.min.js"></script>
<script src="https://unpkg.com/@nepada/phone-number-input@%5E1.0/dist/phone-number-input.min.js"></script>
```

#### Building your own bundle

It is highly recommended to install the client side package via nmp and compile your own bundle. This way you can use your custom build of metadata set mentioned earlier.

Here is an example script for initialization of phone number input and Nette forms.  

```js
import Nette from 'nette-forms';
import initializePhoneNumberInput from '@nepada/phone-number-input';
import metadata from 'libphonenumber-js/metadata.full';
// OR
// import metadata from 'libphonenumber-js/metadata.min';
// OR
// import metadata from 'libphonenumber-js/metadata.mobile';
// OR
// import metadata from './metadata.custom.js';

initializePhoneNumberInput(Nette, metadata);
Nette.initOnLoad();

```
