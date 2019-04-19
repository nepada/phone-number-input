import {testInstances} from './bootstrap';

describe.each(testInstances)('%s', (name, Nette) => {
    test('no default region', () => {
        document.body.innerHTML = '<form><input type="tel" name="phone"></form>';
        const form = document.forms[0];
        const input = form.elements[0];

        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber(input)).toBe(false);

        input.value = 'abcdef';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber(input)).toBe(false);

        input.value = '+42012';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber(input)).toBe(false);

        input.value = '212 345 678';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber(input)).toBe(false);

        input.value = '+420 212 345 678';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber(input)).toBe(true);

        input.value = '+420111111111';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber(input)).toBe(true);
    });

    test('CZ default region', () => {
        document.body.innerHTML = '<form><input type="tel" name="phone" data-default-region-code="CZ"></form>';
        const form = document.forms[0];
        const input = form.elements[0];

        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber(input)).toBe(false);

        input.value = 'abcdef';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber(input)).toBe(false);

        input.value = '+42012';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber(input)).toBe(false);

        input.value = '212 345 678';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber(input)).toBe(true);

        input.value = '+420 212 345 678';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber(input)).toBe(true);

        input.value = '+420111111111';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber(input)).toBe(true);
    });
});
