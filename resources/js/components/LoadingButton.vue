<template>
    <input type="submit" :value="value" :class="[{ 'btn-loading': loading }, 'btn']" :disabled="loading">
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    
    @Component
    export default class LoadingButton extends Vue {
        @Prop(String) value: string;
        @Prop(Boolean) loading: boolean;

        name: string = 'LoadingButton';
    }
</script>

<style lang="scss" scoped>
    .btn-loading {
        background: url("~@/images/button-loader.gif") no-repeat;
        background-size: cover;
    }
</style>
