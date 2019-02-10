import parsePhoneNumberFromString from 'libphonenumber-js/es6/parsePhoneNumberFromString';
import bindToNetteForms from './bindToNetteForms';
import parsePhoneNumberFactory from './parsePhoneNumberFactory';

export default (Nette, metadata) => {
    bindToNetteForms(Nette, parsePhoneNumberFactory(parsePhoneNumberFromString, metadata));
};
