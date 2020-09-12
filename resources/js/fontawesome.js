import {library, dom} from "@fortawesome/fontawesome-svg-core";
import {
    faArchive, faAngleDown,
    faBars,
    faCheck,
    faEye, faExternalLinkAlt,
    faFileAlt, faFilter,
    faLink,
    faPaperPlane, faPencil, faPlus,
    faSave, faSearch,
    faTimes, faTrashRestore,
    faUser, faSpinner
} from "@fortawesome/pro-solid-svg-icons"
import {faLinkedinIn, faGithub, faTwitter} from "@fortawesome/free-brands-svg-icons";

library.add(
    faLinkedinIn, faGithub, faTwitter,
    faTimes, faBars, faPlus, faEye, faPencil,
    faCheck, faFileAlt, faArchive, faTrashRestore,
    faUser, faPaperPlane, faSave,
    faAngleDown, faFilter, faSearch, faLink, faExternalLinkAlt,
    faSpinner
);

dom.watch();
