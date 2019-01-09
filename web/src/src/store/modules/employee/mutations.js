import { mapMutationsFromTypes } from 'schepotin-vuex-helpers';
import * as types from './mutation-types';

export default {
    /**
     * Generates {@link https://vuex.vuejs.org/en/mutations.html | mutations} from
     * {@link https://vuex.vuejs.org/en/mutations.html#using-constants-for-mutation-types | mutation types}
     *
     * Documentation
     * {@link https://www.npmjs.com/package/schepotin-vuex-helpers#mapmutationsfromtypes | mapMutationsFromTypes}
     */
    ...mapMutationsFromTypes({
        types,
        excludes: [
            types.CLEAR,
        ],
    }),
    [types.CLEAR] (state) {
        state.name = null;
        state.image = null;
        state.sociability = 0;
        state.engineering = 0;
        state.timeManagement = 0;
        state.languages = 0;
        state.project = [];
    },
};
