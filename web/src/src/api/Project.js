import BaseProxy from './BaseProxy';

class Project extends BaseProxy {
    constructor(parameters = {}) {
        super('/api/v1/project', parameters);
    }

    async index(params = {}) {
        return this.submit('get', '/', params);
    }
}

export default Project;
