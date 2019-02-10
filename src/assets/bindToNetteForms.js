export default (Nette, parsePhoneNumber) => {
    Nette.getPhoneNumber = (element, value) => {
        if (value === undefined) {
            value = Nette.getEffectiveValue(element);
        }
        const defaultRegion = element.getAttribute('data-default-region-code') || undefined;
        return parsePhoneNumber(value, defaultRegion) || null;
    };

    Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber = (element, argument, value) => {
        const phone = Nette.getPhoneNumber(element, value);
        return !!phone && phone.isPossible();
    };

    Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberStrict = (element, argument, value) => {
        const phone = Nette.getPhoneNumber(element, value);
        return !!phone && phone.isValid();
    };

    Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion = (element, argument, value) => {
        const allowedRegionCodes = Array.isArray(argument) ? argument : [argument];
        const phone = Nette.getPhoneNumber(element, value);
        return !!phone && allowedRegionCodes.includes(phone.country);
    };

};
