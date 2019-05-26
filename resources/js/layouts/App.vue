<template>
    <div :class="[$route.name == 'home' ? 'bg-svg' :  $route.name != 'contact' ? 'bg-gradient': '', 'app']">
        <Header :class="{ 'bg-gradient': $route.name == 'contact' }"></Header>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    import Header from "../components/Header.vue";
    @Component({
        components: {Header}
    })
    export default class App extends Vue {
        name: string = 'App';
    }
</script>

<style lang="scss" scoped>
    .app {
        display: flex;
        flex-flow: column nowrap;
        height: 100%;
    }
    main {
        flex-grow : 1;;
    }
</style>

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
    html, body, #app {
        height: 100%;
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
        display: flex;
        margin: 0 auto;
        max-width: 1300px;
        padding: 0 1.6em;
    }
    .btn {
        background-color: $primary-button-bg-color;
        padding: 10px;
        border-radius: $btn-border-radius;
        color: $secondary-color;
        border: none;
        text-align: center;
        cursor: pointer;

        &:hover {
            background-color: lighten($primary-button-bg-color, 10%);
        }
    }
    .btn-small {
        font-size: 0.8em;
    }
    .bg-svg {
        background: url("../../images/bg2.svg") no-repeat 0 -250px;
        background-size: cover;
    }
    .bg-gradient {
        background: $primary-gradient;
    }
</style>
