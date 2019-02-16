import Nette from 'nette-forms';
import bindToNetteForms from './bindToNetteForms';
import {parsePhoneNumberFromString} from 'libphonenumber-js';

bindToNetteForms(Nette, parsePhoneNumberFromString);
