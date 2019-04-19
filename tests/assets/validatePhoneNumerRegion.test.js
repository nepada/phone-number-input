import {testInstances} from './bootstrap';

describe.each(testInstances)('%s', (name, Nette) => {
    test('no default region', () => {
        document.body.innerHTML = '<form><input type="tel" name="phone"></form>';
        const form = document.forms[0];
        const input = form.elements[0];

        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, 'CZ')).toBe(false);

        input.value = 'abcdef';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, 'CZ')).toBe(false);

        input.value = '212 345 678';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, 'CZ')).toBe(false);
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, ['US', 'CZ'])).toBe(false);
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, 'SK')).toBe(false);
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, ['US', 'SK'])).toBe(false);

        input.value = '+421111111111';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, 'CZ')).toBe(false);
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, ['US', 'CZ'])).toBe(false);
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, 'SK')).toBe(true);
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, ['US', 'SK'])).toBe(true);
    });

    test('CZ default region', () => {
        document.body.innerHTML = '<form><input type="tel" name="phone" data-default-region-code="CZ"></form>';
        const form = document.forms[0];
        const input = form.elements[0];

        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, 'CZ')).toBe(false);

        input.value = 'abcdef';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, 'CZ')).toBe(false);

        input.value = '212 345 678';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, 'CZ')).toBe(true);
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, ['US', 'CZ'])).toBe(true);
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, 'SK')).toBe(false);
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, ['US', 'SK'])).toBe(false);

        input.value = '+421111111111';
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, 'CZ')).toBe(false);
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, ['US', 'CZ'])).toBe(false);
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, 'SK')).toBe(true);
        expect(Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion(input, ['US', 'SK'])).toBe(true);
    });
});
