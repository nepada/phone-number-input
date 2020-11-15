(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('nette-forms'), require('libphonenumber-js')) :
    typeof define === 'function' && define.amd ? define(['nette-forms', 'libphonenumber-js'], factory) :
    (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.Nette, global.libphonenumber));
}(this, (function (Nette, libphonenumberJs) { 'use strict';

    function _interopDefaultLegacy (e) { return e && typeof e === 'object' && 'default' in e ? e : { 'default': e }; }

    var Nette__default = /*#__PURE__*/_interopDefaultLegacy(Nette);

    var bindToNetteForms = (function (Nette, parsePhoneNumber) {
      Nette.getPhoneNumber = function (element, value) {
        if (value === undefined) {
          value = Nette.getEffectiveValue(element);
        }

        var defaultRegion = element.getAttribute('data-default-region-code') || undefined;
        return parsePhoneNumber(value, defaultRegion) || null;
      };

      Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumber = function (element, argument, value) {
        var phone = Nette.getPhoneNumber(element, value);
        return !!phone && phone.isPossible();
      };

      Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberStrict = function (element, argument, value) {
        var phone = Nette.getPhoneNumber(element, value);
        return !!phone && phone.isValid();
      };

      Nette.validators.NepadaPhoneNumberInputValidator_validatePhoneNumberRegion = function (element, argument, value) {
        var allowedRegionCodes = Array.isArray(argument) ? argument : [argument];
        var phone = Nette.getPhoneNumber(element, value);
        return !!phone && allowedRegionCodes.includes(phone.country);
      };
    });

    bindToNetteForms(Nette__default['default'], libphonenumberJs.parsePhoneNumberFromString);

})));
//# sourceMappingURL=phone-number-input.js.map
