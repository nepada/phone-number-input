'use strict';

var bindToNetteForms = require('./bindToNetteForms.js');
var parsePhoneNumberFactory = require('./parsePhoneNumberFactory.js');
var core = require('libphonenumber-js/core');

var index = (Nette, metadata) => {
    bindToNetteForms(Nette, parsePhoneNumberFactory(core.parsePhoneNumberFromString, metadata));
};

module.exports = index;
//# sourceMappingURL=index.js.map
