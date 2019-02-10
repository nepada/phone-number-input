'use strict';

function _interopDefault (ex) { return (ex && (typeof ex === 'object') && 'default' in ex) ? ex['default'] : ex; }

var bindToNetteForms = require('./bindToNetteForms.js');
var parsePhoneNumberFactory = require('./parsePhoneNumberFactory.js');
var parsePhoneNumberFromString = _interopDefault(require('libphonenumber-js/build/parsePhoneNumberFromString'));

var index_cjs = (Nette, metadata) => {
    bindToNetteForms(Nette, parsePhoneNumberFactory(parsePhoneNumberFromString, metadata));
};

module.exports = index_cjs;
//# sourceMappingURL=index.cjs.js.map
