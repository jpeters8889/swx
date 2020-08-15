import {library, dom} from '@fortawesome/fontawesome-svg-core'
import {faSpinner} from "@fortawesome/free-solid-svg-icons/faSpinner";
import {faTimes} from "@fortawesome/free-solid-svg-icons/faTimes";

export default () => {
    library.add(faSpinner);
    library.add(faTimes);

    dom.watch();
}
