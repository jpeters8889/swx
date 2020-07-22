import {library, dom} from '@fortawesome/fontawesome-svg-core'
import {faSpinner} from "@fortawesome/free-solid-svg-icons/faSpinner";

export default () => {
    library.add(faSpinner);

    dom.watch();
}
