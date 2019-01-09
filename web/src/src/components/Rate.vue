<template>
    <div class="mb-2">
        <p class="h6">{{ title }}</p>
        <div class="rates-container">
            <template v-for="n in constants.MAX_RATE">
                <div :key="n" class="rate">
                    <input type="radio" id="one" :value="n" v-model="picked">
                    <label for="one">{{ n }}</label>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    import * as constants from '../utils/constants';

    export default {
        data() {
            return {
                constants,
                picked: 1,
            };
        },
        props: {
            title: {
                type: String,
                required: true,
            },
            value: {
                required: true,
            }
        },
        watch: {
            picked(newValue) {
                this.$emit('input', newValue);
            }
        }
    };
</script>

<style scoped>
    .rates-container {
        flex-direction: row;
        display: flex;
    }

    .rate {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
</style>
