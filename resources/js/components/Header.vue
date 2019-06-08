<template>
    <header>
        <div class="wrapper">
            <router-link :to="{ name: 'home' }" class="logo">Broussel</router-link>
            <nav class="desktop">
                <ul>
                    <li>
                        <router-link :to="{ name: 'faq' }">FAQ</router-link>
                    </li><li>
                        <router-link :to="{ name: 'register-buddy' }">Word wandelbuddy</router-link>
                    </li><li>
                        <router-link :to="{ name: 'contact' }">Contact</router-link>
                    </li>
                </ul>
                <ul v-if="$auth.check()">
                    <li>
                        <router-link :to="{ name: 'dashboard' }">App</router-link>
                    </li><li>
                        <a href="#" @click.prevent="logout()" class="btn">Uitloggen</a>
                    </li>
                </ul>
                <ul v-else>
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
            <Slide right noOverlay>
                <nav class="mobile">
                    <ul>
                        <li>
                            <router-link :to="{ name: 'faq' }">FAQ</router-link>
                        </li><li>
                            <router-link :to="{ name: 'register-buddy' }">Word wandelbuddy</router-link>
                        </li><li>
                            <router-link :to="{ name: 'contact' }">Contact</router-link>
                        </li>
                        <a-divider></a-divider>
                        <template v-if="$auth.check()">
                            <li>
                                <router-link :to="{ name: 'dashboard' }">App</router-link>
                            </li><li>
                                <a href="#" @click.prevent="logout()" class="btn">Uitloggen</a>
                            </li>
                        </template>
                        <template v-else>
                            <li>
                                <router-link :to="{ name: 'login' }">Log in</router-link>
                            </li><li>
                                <router-link :to="{ name: 'register' }" class="btn">Registreren</router-link>
                            </li>
                        </template>
                        <a-divider></a-divider>
                        <li>
                            <router-link :to="{ name: 'register' }">Nederlands</router-link>
                        </li><li>
                            <router-link :to="{ name: 'register' }">Français</router-link>
                        </li>
                    </ul>
                </nav>
            </Slide>
        </div>
    </header>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import { State } from 'vuex-class';
    import { Slide } from 'vue-burger-menu';

    @Component({
        components: {
            Slide,
        }
    })
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

<style lang="scss">
    // Burger menu style
    .bm-burger-button {
        display: none;
    }
    .bm-burger-bars {
        background-color: $light-color;
    }
    .bm-burger-button {
        top: 18px;
    }
    .bm-menu {
        background-color: $dark-primary-accent-color;
    }
    .bm-cross {
        background-color: $light-color;
    }
    @media screen and (max-width: 900px) {
        .bm-burger-button {
            display: initial;
        }
    }
</style>

<style lang="scss" scoped>
    header, a {
        color: $light-color;
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
        font-size: 1.1em;
    }
    nav.desktop {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;

        a:hover:not(.btn) {
            padding-bottom: 5px;
            border-bottom: 3px solid #ffffff;
        }
        li {
            margin: 0 10px;
        }
    }
    nav.mobile {
        li {
            display: block;
            margin: 10px 0;
        }
    }
    .langs {
        font-size: 0.8em;
        
        a:hover {
            text-decoration: underline;
        }
    }
    @media screen and (max-width: 900px) {
        nav.desktop, nav.desktop + .langs {
            display: none;
        }
    }
</style>
