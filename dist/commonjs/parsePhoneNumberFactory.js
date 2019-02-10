'use strict';

var parsePhoneNumberFactory = (parsePhoneNumberFromString, metadata) => {
    return (text, defaultRegionCode) => {
        return parsePhoneNumberFromString(text, defaultRegionCode, metadata);
    };
};

module.exports = parsePhoneNumberFactory;
//# sourceMappingURL=parsePhoneNumberFactory.js.map
