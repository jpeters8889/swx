import {library, dom} from '@fortawesome/fontawesome-svg-core'
import {faSpinner} from "@fortawesome/free-solid-svg-icons/faSpinner";
import {faTimes} from "@fortawesome/free-solid-svg-icons/faTimes";
import {faCheck} from "@fortawesome/free-solid-svg-icons/faCheck";

export default () => {
    library.add(faSpinner);
    library.add(faTimes);
    library.add(faCheck);

    dom.watch();
}
