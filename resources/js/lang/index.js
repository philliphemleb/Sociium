import Vue from 'vue';
import VueI18n from "vue-i18n";
import de_messages from "./de";

Vue.use(VueI18n);

const messages = {
    de: de_messages
}

export default new VueI18n({
    locale: 'de',
    messages
});
