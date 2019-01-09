import Vue from 'vue';
import VeeValidate from 'vee-validate';

import validationEn from '../lang/en/validator';

Vue.use(VeeValidate, {
    fieldsBagName: 'fieldsValidation',
    locale: 'en',
    dictionary: {
        en: validationEn,
    },
});
