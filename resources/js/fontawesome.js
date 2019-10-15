import { library, dom } from "@fortawesome/fontawesome-svg-core";
import {
    faLinkedinIn,
    faGithub,
    faTwitter
} from "@fortawesome/free-brands-svg-icons";

library.add(faLinkedinIn, faGithub, faTwitter);

dom.i2svg();
