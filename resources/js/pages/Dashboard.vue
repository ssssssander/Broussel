<template>
    <div class="dashboard fullscreen">
        <div class="white-bg">
            <h1>Dashboard</h1>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class AppHome extends Vue {
        name: string = 'AppHome';

        mounted() {

        }
    }
</script>

<style lang="scss" scoped>

</style>
