import Vue from 'vue'
import VueI18n from 'vue-i18n';

Vue.use(VueI18n)

import { languages } from './i18n/index.js';
import { defaultLocale } from './i18n/index.js';
// Expected value= Object { en:en, es:es }
const messages = Object.assign(languages);

// I18n object
var i18n = new VueI18n({
  locale: defaultLocale,
  fallbackLocale: 'de',
  messages
})

export default i18n
