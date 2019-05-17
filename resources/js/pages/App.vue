<template>
    <div>
        <template v-if="$route.name == 'home'">
            <Hero>
                <Header></Header>
            </Hero>
        </template>
        <template v-else>
            <Header></Header>
        </template>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    import Header from '../components/Header.vue';
    import Hero from '../components/Hero.vue';

    @Component({
        components: {
            Header,
            Hero,
        },
    })
    export default class App extends Vue {
        @Prop(String) isAuth!: string;

        name: string = 'App';

        mounted() {
            console.log(this.isAuth);
        }
    }
</script>

<style lang="scss">
    // Global Sass
    * {
        margin: 0;
        padding: 0;
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
    a {
        text-decoration: none;
    }
    ul {
        list-style-type: none;
    }
    li {
        display: inline-block;
    }
    .wrapper {
        margin: 0 auto;
        max-width: 1300px;
        padding: 0 1.6em;
    }
    .bg {
        background-image: $primary-gradient;
    }
</style>
