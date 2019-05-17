<template>
    <div>
        <Hero></Hero>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import Hero from '../components/Hero.vue';

    @Component({
        components: {
            Hero,
        },
    })
    export default class App extends Vue {
        name: string = 'App';
    }
</script>

<style lang="scss">
    // Global Sass
    * {
        box-sizing: border-box;
    }
    :root {
        font-size: $base-font-size;
    }
    body {
        font-size: 1rem;
        position: relative;
        font-family: $primary-font-family;
        line-height: $base-line-height;
    }
    .wrapper {
        margin: 0 auto;
        max-width: 1300px;
    }
</style>
