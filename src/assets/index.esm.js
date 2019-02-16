import bindToNetteForms from './bindToNetteForms';
import parsePhoneNumberFactory from './parsePhoneNumberFactory';
import parsePhoneNumberFromString from 'libphonenumber-js/es6/parsePhoneNumberFromString';

export default (Nette, metadata) => {
    bindToNetteForms(Nette, parsePhoneNumberFactory(parsePhoneNumberFromString, metadata));
};
