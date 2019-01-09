import Employee from '../../../api/Employee';
import * as types from './mutation-types';

export const store = async (context, data) => {
    await new Employee().store(data);
};

export const uploadImage = async (context, data) => {
    return await new Employee().uploadImage(data);
};

export const getAverage = async () => {
    return await new Employee().getAverage();
};

export const clear = async ({ commit }) => {
    commit(types.CLEAR, null)
};

export default {
    store,
    uploadImage,
    getAverage,
    clear,
};
