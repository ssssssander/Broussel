<template>
    <header :class="{ 'bg': $route.name != 'home' }">
        <div class="wrapper">
            <router-link :to="{ name: 'home' }" class="logo">broussel</router-link>
            <nav>
                <ul>
                    <li>
                        <router-link :to="{ name: 'contact' }">Voor gidsen </router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'contact' }">Contact</router-link>
                    </li>
                </ul>
                <ul>
                    <li>
                        <router-link :to="{ name: 'contact' }">Log in</router-link>
                    </li>
                    <li class="register">
                        <router-link :to="{ name: 'contact' }">Register</router-link>
                    </li>
                </ul>
            </nav>
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
    header {
        a {
            color: $secondary-color;
        }
        .wrapper {
            display: flex;
            align-items: center;
        }
        .logo {
            font-family: $logo-font-family;
            font-size: 3rem;
            margin-right: 20px;
        }
        nav {
            width: 100%;
            margin-top: 5px;
            font-size: 1.3rem;
            display: flex;
            justify-content: space-between;
        }
        li {
            margin: 0 10px;
        }

    }
</style>
