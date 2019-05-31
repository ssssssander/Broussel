<template>
    <div class="error-404">
        <div class="box">
            <h1>Error 404</h1>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Error404 extends Vue {
        name: string = 'Error404';
    }
</script>

<style lang="scss" scoped>

</style>
