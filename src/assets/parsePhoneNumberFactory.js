export default (parsePhoneNumberFromString, metadata) => {
    return (text, defaultRegionCode) => {
        return parsePhoneNumberFromString(text, defaultRegionCode, metadata);
    };
};
