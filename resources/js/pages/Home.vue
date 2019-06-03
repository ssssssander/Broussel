<template>
    <div class="home">
        <Hero></Hero>
        <div class="content">
            <h2>Hoe het werkt</h2>
            <p>Blabla</p>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Home extends Vue {
        name: string = 'Home';
    }
</script>

<style lang="scss" scoped>
    .content {
        margin-top: 20px;
    }
</style>
