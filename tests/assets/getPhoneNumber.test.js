import {testInstances} from './bootstrap';

describe.each(testInstances)('%s', (name, Nette) => {
    test('no default region', () => {
        document.body.innerHTML = '<form><input type="tel" name="phone"></form>';
        const form = document.forms[0];
        const input = form.elements[0];
        let phoneNumber;

        phoneNumber = Nette.getPhoneNumber(input);
        expect(phoneNumber).toBeNull();

        input.value = 'abcdef';
        phoneNumber = Nette.getPhoneNumber(input);
        expect(phoneNumber).toBeNull();

        input.value = '800 12 34 56';
        phoneNumber = Nette.getPhoneNumber(input);
        expect(phoneNumber).toBeNull();

        input.value = '+420 800 12 34 56';
        phoneNumber = Nette.getPhoneNumber(input);
        expect(phoneNumber.country).toBe('CZ');
        expect(phoneNumber.number).toBe('+420800123456');

        input.value = '+421 800 12 34 56';
        phoneNumber = Nette.getPhoneNumber(input);
        expect(phoneNumber.country).toBe('SK');
        expect(phoneNumber.number).toBe('+421800123456');
    });

    test('CZ default region', () => {
        document.body.innerHTML = '<form><input type="tel" name="phone" data-default-region-code="CZ"></form>';
        const form = document.forms[0];
        const input = form.elements[0];
        let phoneNumber;

        phoneNumber = Nette.getPhoneNumber(input);
        expect(phoneNumber).toBeNull();

        input.value = 'abcdef';
        phoneNumber = Nette.getPhoneNumber(input);
        expect(phoneNumber).toBeNull();

        input.value = '800 12 34 56';
        phoneNumber = Nette.getPhoneNumber(input);
        expect(phoneNumber.country).toBe('CZ');
        expect(phoneNumber.number).toBe('+420800123456');

        input.value = '+420 800 12 34 56';
        phoneNumber = Nette.getPhoneNumber(input);
        expect(phoneNumber.country).toBe('CZ');
        expect(phoneNumber.number).toBe('+420800123456');

        input.value = '+421 800 12 34 56';
        phoneNumber = Nette.getPhoneNumber(input);
        expect(phoneNumber.country).toBe('SK');
        expect(phoneNumber.number).toBe('+421800123456');
    });
});
