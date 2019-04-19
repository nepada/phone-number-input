import {testInstances} from './bootstrap';

describe.each(testInstances)('%s', (name1, Nette1) => {
    describe.each(testInstances)('%s', (name2, Nette2) => {
        if (name1 === name2) {
            return;
        }

        test('getPhoneNumber', () => {
            expect(Nette1.getPhoneNumber).toBeDefined();
            expect(Nette1.getPhoneNumber)
                .not.toBe(Nette2.getPhoneNumber);
        });

        test('validatePhoneNumber', () => {
            expect(Nette1.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber).toBeDefined();
            expect(Nette1.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber)
                .not.toBe(Nette2.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber);
        });

        test('validatePhoneNumberStrict', () => {
            expect(Nette1.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberStrict).toBeDefined();
            expect(Nette1.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberStrict)
                .not.toBe(Nette2.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberStrict);
        });

        test('validatePhoneNumberRegion', () => {
            expect(Nette1.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion).toBeDefined();
            expect(Nette1.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion)
                .not.toBe(Nette2.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion);
        });
    });
});
