<template>
    <div v-show="Object.keys(errors).length || errorType" class="errors">
        <ul>
            <li v-show="errorType">
                <span>{{ errorType }}</span>
            </li>
            <li v-for="errorArr in errors">
                <span v-for="error in errorArr" class="error">
                    <a-icon type="exclamation-circle" /><span>{{ error }}</span>
                </span>
            </li>
        </ul>
    </div>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    
    @Component
    export default class Error extends Vue {
        @Prop(Object) errors: object;
        @Prop(String) errorType: string;

        name: string = 'Error';
    }
</script>

<style lang="scss" scoped>
    
</style>
