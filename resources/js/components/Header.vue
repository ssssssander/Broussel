<template>
    <header>
        <div class="wrapper">
            <router-link :to="{ name: 'home' }" class="logo">Broussel</router-link>
            <nav>
                <ul>
                    <li>
                        <router-link :to="{ name: 'register-buddy' }">Voor wandelbuddies</router-link>
                    </li><li>
                        <router-link :to="{ name: 'contact' }">Contact</router-link>
                    </li>
                </ul>
                <ul v-if="!$auth.check()">
                    <li>
                        <router-link :to="{ name: 'login' }">Log in</router-link>
                    </li><li>
                        <router-link :to="{ name: 'register' }" class="btn">Registreren</router-link>
                    </li>
                </ul>
                <ul v-if="$auth.check()">
                    <li>
                        <router-link :to="{ name: 'dashboard' }">App</router-link>
                    </li>
                    <li>
                        <a href="#" @click.prevent="logout()" class="btn">Uitloggen</a>
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
    import { State } from 'vuex-class';

    @Component
    export default class Header extends Vue {
        @State('userData') user: any;

        name: string = 'Header';

        logout() {
            (this as any).$auth.logout({
                success: (response: any) => {
                    // Clear store of user data
                    for (let data in this.user) delete this.user[data];

                    this.$message.success('Je bent met succes uitgelogd!');
                },
                error: (error: any) => {
                    this.$message.error('Er is iets misgegaan bij het uitloggen, probeer het opnieuw.');
                },
            });
        }
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
        display: flex;
        align-items: center;
    }
    .logo {
        font-family: $logo-font-family;
        font-size: 3em;
        margin-right: 40px;
        text-transform: lowercase;
    }
    nav {
        width: 100%;
        font-size: 1.1em;
        display: flex;
        justify-content: space-between;
    }
    @media screen and (max-width: 1000px) {
        nav, .langs {
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
