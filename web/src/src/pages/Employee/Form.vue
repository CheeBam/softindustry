<template>
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-8 offset-md-2 col-xs-12">
                <form class="form-horizontal" @submit.prevent="create" data-vv-scope="mainForm">
                    <div class="card mb-1">
                        <div class="card-header">
                            <h3 class="card-title">{{ $t('translation.createEmployee') }}</h3>
                        </div>
                        <div class="card-body row">
                            <div v-if="progress" class="loading"></div>
                            <div class="col-sm-12 col-md-8">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="name">{{ $t('translation.name') }}</label>
                                    </div>
                                    <input id="name"
                                           type="text"
                                           class="form-control"
                                           :class="{ 'is-invalid': errors.has('mainForm.name') }"
                                           :placeholder="$t('translation.name')"
                                           v-model="employeeName"
                                           name="name"
                                           v-validate="'required|max:255'"
                                           data-vv-validate-on="none"
                                           data-vv-name="name"
                                           data-vv-scope="mainForm"
                                           @focus="clearError($event, 'mainForm')"
                                    >
                                    <div v-show="errors.has('mainForm.name')" class="invalid-feedback">
                                        {{ errors.first('mainForm.name') }}
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ $t('translation.upload') }}</span>
                                    </div>
                                    <div class="custom-file">
                                        <input name="image"
                                               type="file"
                                               class="custom-file-input"
                                               id="image"
                                               @change="onFileChange($event)"
                                        >
                                        <label class="custom-file-label" for="image">{{ $t('translation.chooseFile') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 d-flex justify-content-center">
                                <img height="90" alt="avatar" :src="baseUrl + employeeImage"/>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <rate :title="$t('translation.sociability')" v-model="employeeSociability"></rate>
                                </div>
                                <div class="form-group">
                                    <rate :title="$t('translation.engineering')" v-model="employeeEngineering"></rate>
                                </div>
                                <div class="form-group">
                                    <rate :title="$t('translation.timeManagement')" v-model="employeeTimeManagement"></rate>
                                </div>
                                <div class="form-group">
                                    <rate :title="$t('translation.languages')" v-model="employeeLanguages"></rate>
                                </div>
                                <div class="form-group">
                                    <multiselect v-model="employeeProject"
                                                 :options="projectList"
                                                 label="title"
                                                 track-by="id"
                                                 :multiple="multiple"
                                                 :select-label="$t('translation.selectProject')"
                                                 :placeholder="$t('translation.selectProject')"
                                                 :allow-empty="true"
                                    >
                                    </multiselect>
                                </div>
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn login-btn btn-block btn-success custom-btn" :disabled="this.progress">{{ $t('translation.create') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    import objectToFormdata from 'object-to-formdata';
    import Rate from '../../components/Rate';
    import employeeMixin from '../../mixins/employee';
    import projectMixin from '../../mixins/project';
    import * as constants from '../../utils/constants';

    export default {
        metaInfo() {
            return {
                title: this.$t('translation.createEmployee'),
            };
        },
        components: {
            Multiselect,
            Rate,
        },
        mixins: [ employeeMixin, projectMixin ],
        computed: {
            baseUrl() {
                return `${window.location.protocol}//api.${window.location.hostname}`;
            },
            multiple() {
                return this.employeeTimeManagement >= constants.ADVANCED_TIME_MANAGEMENT;
            }
        },
        data() {
            return {
                constants,
                progress: false,
            };
        },
        methods: {
            clearError(event, scope) {
                this.$validator.flag(`${scope}.${event.target.name}`, { invalid: false });
                this.errors.remove(event.target.name, scope);
            },
            async onFileChange(event) {
                const files = event.target.files;

                if (!files.length) return false;

                const data = objectToFormdata({
                    image: files[0],
                });

                this.employeeImage = await this.$store.dispatch('employee/uploadImage', data);
            },
            async create() {
                const valid = await this.$validator.validateAll('mainForm');

                if (valid) {
                    this.progress = true;

                    try {
                        await this.$store.dispatch('employee/store', {
                            name: this.employeeName,
                            image: this.employeeImage,
                            sociability: this.employeeSociability,
                            engineering: this.employeeEngineering,
                            time_management: this.employeeTimeManagement,
                            languages: this.employeeLanguages,
                            project: this.employeeProject,
                        });

                        this.progress = false;
                        this.$router.push({ name: 'employee.index' });

                    } catch (e) {
                        console.error(e);
                        this.progress = false;
                    }
                }
            }
        },
        mounted() {
            this.employeeImage = constants.DEFAULT_IMAGE_PATH;
            this.$store.dispatch('project/index');
        },
        watch: {
            employeeTimeManagement(newValue, oldValue) {
                if (oldValue >= constants.ADVANCED_TIME_MANAGEMENT && newValue < constants.ADVANCED_TIME_MANAGEMENT && this.employeeProject.length > 1) {
                    this.employeeProject = this.employeeProject[0];
                }
            },
        },
        beforeDestroy() {
            this.$store.dispatch('employee/clear');
        },
    };
</script>
