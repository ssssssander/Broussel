<template>
    <div class="home">
        <Hero></Hero>
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

</style>
