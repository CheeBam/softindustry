<template>
    <div class="container">
        <div class="row d-flex">
            <div class="col-12">
                <div v-if="progress" class="loading"></div>

                <div class="input-group mb-3">
                    <input type="text" v-model="searchText" class="form-control" :placeholder="$t('translation.search')" aria-label="" aria-describedby="basic-addon">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" @click="onFilterReset" type="button">{{ $t("translation.reset") }}</button>
                    </div>
                </div>

                <vuetable
                        ref="vuetable"
                        :api-url="`${baseUrl}/api/v1/employee`"
                        data-path="data"
                        pagination-path=""
                        :append-params="queryParams"
                        :fields="fields"
                        :css="css.table"
                        @vuetable:loading="progress = true"
                        @vuetable:loaded="progress = false"
                        @vuetable:pagination-data="onPaginationData">

                    <template slot="image" slot-scope="props">
                        <img height="30" :src="baseUrl + props.rowData.image"/>
                    </template>

                </vuetable>
                <vuetable-pagination
                        ref="pagination"
                        :css="css.pagination"
                        @vuetable-pagination:change-page="onChangePage"
                >
                </vuetable-pagination>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Averages
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(item, key) in averages" :key="key">
                                {{ $t(`translation.${key}`) }}
                                <span class="badge badge-primary badge-pill">{{ item }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vuetable from 'vuetable-2/src/components/Vuetable.vue';
    import VuetablePagination from 'vuetable-2/src/components/VuetablePagination.vue';
    import debounce from '../../utils/helper';
    import * as constants from '../../utils/constants';

    export default {
        components: {
            Vuetable,
            VuetablePagination,
        },
        computed: {
            baseUrl() {
                return `${window.location.protocol}//api.${window.location.hostname}`;
            }
        },
        data() {
            return {
                constants,
                fields: [
                    {
                        name: 'name',
                        sortField: 'name',
                        title: this.$t('translation.name'),
                        titleClass: 'text-left col',
                        dataClass: 'text-left middle index',
                    },
                    {
                        name: '__slot:image',
                        title: this.$t('translation.image'),
                        titleClass: 'text-left col',
                        dataClass: 'text-center middle index',
                    },
                    {
                        name: 'sociability',
                        sortField: 'sociability',
                        title: this.$t('translation.sociability'),
                        titleClass: 'text-left col',
                        dataClass: 'text-center middle index',
                    },
                    {
                        name: 'engineering',
                        sortField: 'engineering',
                        title: this.$t('translation.engineering'),
                        titleClass: 'text-left col',
                        dataClass: 'text-center middle index',
                    },
                    {
                        name: 'time_management',
                        sortField: 'time_management',
                        title: this.$t('translation.timeManagement'),
                        titleClass: 'text-left col text-nowrap',
                        dataClass: 'text-center middle index',
                    },
                    {
                        name: 'languages',
                        sortField: 'languages',
                        title: this.$t('translation.languages'),
                        titleClass: 'text-left col',
                        dataClass: 'text-center middle index',
                    },
                    {
                        name: 'projects_count',
                        sortField: 'projects_count',
                        title: this.$t('translation.projects'),
                        titleClass: 'text-left col',
                        dataClass: 'text-center middle index',
                    },
                ],
                css: {
                    table: {
                        tableClass: 'table',
                        loadingClass: 'loading',
                        ascendingIcon: 'glyphicon glyphicon-chevron-up',
                        descendingIcon: 'glyphicon glyphicon-chevron-down',
                        handleIcon: 'glyphicon glyphicon-menu-hamburger',
                    },
                    pagination: {
                        infoClass: 'pull-left',
                        wrapperClass: 'vuetable-pagination',
                        activeClass: 'btn-primary',
                        disabledClass: 'disabled',
                        pageClass: 'btn btn-border',
                        linkClass: 'btn btn-border',
                        icons: {
                            first: '<<',
                            prev: '<',
                            next: '>',
                            last: '>>',
                        },
                    },
                },
                progress: false,
                queryParams: {
                    search: '',
                    per_page: constants.PER_PAGE,
                },
                searchText: '',
                averages: {},
            };
        },
        methods: {
            onFilterReset() {
                this.searchText = '';
                this.queryParams.search = '';
                this.$nextTick(() => this.$refs.vuetable.refresh());
            },
            onChangePage(page) {
                this.$refs.vuetable.changePage(page);
            },
            onPaginationData(paginationData) {
                this.$refs.pagination.setPaginationData(paginationData);
            },
        },
        async mounted() {
            this.averages = await this.$store.dispatch('employee/getAverage');
        },
        watch: {
            searchText: debounce(function (value) {
                this.queryParams.search = value;
                this.$nextTick(() => this.$refs.vuetable.refresh())
            }, constants.DEBOUNCE_INTERVAL)
        },
    };
</script>
