import {library, dom} from "@fortawesome/fontawesome-svg-core";
import {
    faArchive,
    faBars,
    faCheck,
    faEye, faFileAlt,
    faPencil,
    faPlus,
    faTimes, faTrashRestore
} from "@fortawesome/pro-solid-svg-icons"
import {faLinkedinIn, faGithub, faTwitter} from "@fortawesome/free-brands-svg-icons";

library.add(
    faLinkedinIn, faGithub, faTwitter,
    faTimes, faBars, faPlus, faEye, faPencil, faCheck, faFileAlt, faArchive, faTrashRestore
);

dom.i2svg();
