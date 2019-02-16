import bindToNetteForms from './bindToNetteForms';
import parsePhoneNumberFactory from './parsePhoneNumberFactory';
import parsePhoneNumberFromString from 'libphonenumber-js/build/parsePhoneNumberFromString';

export default (Nette, metadata) => {
    bindToNetteForms(Nette, parsePhoneNumberFactory(parsePhoneNumberFromString, metadata));
};
