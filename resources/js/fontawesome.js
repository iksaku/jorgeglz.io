import {library, dom} from "@fortawesome/fontawesome-svg-core";
import {
    faArchive, faAngleDown,
    faBars,
    faCheck,
    faEye, faFileAlt, faFilter, faPaperPlane,
    faPencil,
    faPlus, faSave, faSyncAlt,
    faTimes, faTrashRestore,
    faUser, faSearch
} from "@fortawesome/pro-solid-svg-icons"
import {faLinkedinIn, faGithub, faTwitter} from "@fortawesome/free-brands-svg-icons";

library.add(
    faLinkedinIn, faGithub, faTwitter,
    faTimes, faBars, faPlus, faEye, faPencil,
    faCheck, faFileAlt, faArchive, faTrashRestore,
    faUser, faPaperPlane, faSave, faSyncAlt,
    faAngleDown, faFilter, faSearch
);

dom.watch();
