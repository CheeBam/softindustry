<template>
    <div id="app">
        <navbar-header/>

        <transition name="slide-fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    import Header from '../components/Header.vue';

    export default {
        components: {
            'navbar-header': Header,
        },
    };
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style lang="scss">
    .slide-fade-enter-active {
        transition: all .2s ease;
    }

    .slide-fade-leave-active {
        transition: all .2s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }

    .slide-fade-enter, .slide-fade-leave-active {
        transform: translateX(10px);
        opacity: 0;
    }
</style>
