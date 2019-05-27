<template>
    <header>
        <div class="wrapper">
            <router-link :to="{ name: 'home' }" class="logo">Broussel</router-link>
            <nav>
                <ul>
                    <li>
                        <router-link :to="{ name: 'contact' }">Voor wandelbuddies</router-link>
                    </li><li>
                        <router-link :to="{ name: 'contact' }">Contact</router-link>
                    </li>
                </ul>
                <ul>
                    <li>
                        <router-link :to="{ name: 'login' }">Log in</router-link>
                    </li><li>
                        <router-link :to="{ name: 'register' }" class="btn">Registreren</router-link>
                    </li>
                </ul>
            </nav>
            <ul class="langs">
                <li>
                    <router-link :to="{ name: 'register' }">Nederlands</router-link>
                </li><li>
                    <router-link :to="{ name: 'register' }">Français</router-link>
                </li>
            </ul>
        </div>
    </header>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Header extends Vue {
        name: string = 'Header';
    }
</script>

<style lang="scss" scoped>
    header, a {
        color: $light-color;
    }
    nav a:hover:not(.logo):not(.btn) {
        padding-bottom: 5px;
        border-bottom: 3px solid #ffffff;
    }
    .wrapper {
        align-items: center;
    }
    .logo {
        font-family: $logo-font-family;
        font-size: 3rem;
        margin-right: 40px;
        text-transform: lowercase;
    }
    nav {
        width: 100%;
        font-size: 1.1rem;
        display: flex;
        justify-content: space-between;
    }
    @media screen and (max-width: 900px) {
        nav {
            display: none;
        }
    }
    li {
        margin: 0 10px;
    }
    .langs {
        font-size: 0.8em;
        
        a:hover {
            text-decoration: underline;
        }
    }
</style>
