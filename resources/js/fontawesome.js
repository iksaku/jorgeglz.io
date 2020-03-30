import {library, dom} from "@fortawesome/fontawesome-svg-core";
import {
    faArchive,
    faBars,
    faCheck,
    faEye, faFileAlt, faPaperPlane,
    faPencil,
    faPlus, faSave,
    faTimes, faTrashRestore,
    faUser
} from "@fortawesome/pro-solid-svg-icons"
import {faLinkedinIn, faGithub, faTwitter} from "@fortawesome/free-brands-svg-icons";

library.add(
    faLinkedinIn, faGithub, faTwitter,
    faTimes, faBars, faPlus, faEye, faPencil,
    faCheck, faFileAlt, faArchive, faTrashRestore,
    faUser, faPaperPlane, faSave
);

dom.i2svg();
