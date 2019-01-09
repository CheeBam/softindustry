import Vue from 'vue';
import VueI18n from 'vue-i18n';

import en from '../lang/en/en';

Vue.use(VueI18n);

document.querySelector('html').setAttribute('lang', 'en');

export default new VueI18n({
    locale: 'en',
    messages: {
        en,
    },
});
