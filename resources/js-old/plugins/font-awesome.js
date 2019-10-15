import Vue from "vue";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faGithub,
    faLinkedinIn,
    faTwitter
} from "@fortawesome/free-brands-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faGithub, faLinkedinIn, faTwitter);

Vue.component("icon", FontAwesomeIcon);
