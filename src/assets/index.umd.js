import {parsePhoneNumberFromString} from 'libphonenumber-js';
import bindToNetteForms from './bindToNetteForms';
import Nette from 'nette-forms';

bindToNetteForms(Nette, parsePhoneNumberFromString);
