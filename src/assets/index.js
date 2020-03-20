import bindToNetteForms from './bindToNetteForms';
import parsePhoneNumberFactory from './parsePhoneNumberFactory';
import {parsePhoneNumberFromString} from 'libphonenumber-js/core';

export default (Nette, metadata) => {
    bindToNetteForms(Nette, parsePhoneNumberFactory(parsePhoneNumberFromString, metadata));
};
