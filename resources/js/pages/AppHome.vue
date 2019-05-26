<template>
    <div class="app-home">
        <div class="dashboard">
            <h1>dis dashb</h1>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class AppHome extends Vue {
        name: string = 'AppHome';
    }
</script>

<style lang="scss" scoped>
    .dashboard {
        margin: 0 auto;
        width: 80%;
        padding: 30px;
        border-radius: $default-border-radius;
        background-color: $secondary-color;
        box-shadow: 0 2px 4px 0 rgba(14, 30, 37, 0.12);
    }
</style>
