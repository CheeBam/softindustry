import Project from '../../../api/Project';
import * as types from './mutation-types';

export const index = async ({commit}, params) => {
    const json = await new Project().index(params);

    commit(types.LIST, json);
};

export default {
    index,
};
