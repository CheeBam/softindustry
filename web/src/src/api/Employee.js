import BaseProxy from './BaseProxy';

class Employee extends BaseProxy {
    constructor(parameters = {}) {
        super('/api/v1/employee', parameters);
    }

    // async index(params = {}) {
    //     return this.submit('get', '/', params);
    // }
    //
    // async show(id) {
    //     return this.submit('get', `/${id}`);
    // }

    async store(params) {
        return this.submit('post', `/`, params);
    }

    async uploadImage(data) {
        return this.submit('post', '/image', data)
    }

    async getAverage(data) {
        return this.submit('post', '/average', data)
    }

    // async destroy(id) {
    //     return this.submit('delete', `/${id}`);
    // }
}

export default Employee;
