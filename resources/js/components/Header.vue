<template>
    <header>
        <div class="wrapper">
            <router-link :to="{ name: 'home', params: { locale: $lang.getLocale() } }" class="logo">Broussel</router-link>
            <nav class="desktop">
                <ul>
                    <li>
                        <router-link :to="{ name: 'faq', params: { locale: $lang.getLocale() } }">{{ 'vue.faq' | trans }}</router-link>
                    </li><li>
                        <router-link :to="{ name: 'register-buddy', params: { locale: $lang.getLocale() } }">{{ 'vue.become_walking_buddy' | trans }}</router-link>
                    </li><li>
                        <router-link :to="{ name: 'contact', params: { locale: $lang.getLocale() } }">{{ 'vue.contact' | trans }}</router-link>
                    </li>
                </ul>
                <ul v-if="$auth.check()">
                    <li>
                        <router-link :to="{ name: appLink, params: { locale: $lang.getLocale() } }">{{ 'vue.app' | trans }}</router-link>
                    </li><li>
                        <a href="#" @click.prevent="logout()" class="btn">{{ 'vue.log_out' | trans }}</a>
                    </li>
                </ul>
                <ul v-else>
                    <li>
                        <router-link :to="{ name: 'login', params: { locale: $lang.getLocale() } }">{{ 'vue.log_in' | trans }}</router-link>
                    </li><li>
                        <router-link :to="{ name: 'register', params: { locale: $lang.getLocale() } }" class="btn">{{ 'vue.register' | trans }}</router-link>
                    </li>
                </ul>
            </nav>
            <ul class="langs">
                <li>
                    <a href="#" @click.prevent="setLocale('nl')">{{ 'vue.nl' | trans }}</a>
                </li><li>
                    <a href="#" @click.prevent="setLocale('fr')">{{ 'vue.fr' | trans }}</a>
                </li>
            </ul>
            <Slide right noOverlay>
                <nav class="mobile">
                    <ul>
                        <li>
                            <router-link :to="{ name: 'faq', params: { locale: $lang.getLocale() } }">{{ 'vue.faq' | trans }}</router-link>
                        </li><li>
                            <router-link :to="{ name: 'register-buddy', params: { locale: $lang.getLocale() } }">{{ 'vue.become_walking_buddy' | trans }}</router-link>
                        </li><li>
                            <router-link :to="{ name: 'contact', params: { locale: $lang.getLocale() } }">>{{ 'vue.contact' | trans }}</router-link>
                        </li>
                        <a-divider></a-divider>
                        <template v-if="$auth.check()">
                            <li>
                                <router-link :to="{ name: appLink, params: { locale: $lang.getLocale() } }">>{{ 'vue.app' | trans }}</router-link>
                            </li><li>
                                <a href="#" @click.prevent="logout()" class="btn">>{{ 'vue.log_out' | trans }}</a>
                            </li>
                        </template>
                        <template v-else>
                            <li>
                                <router-link :to="{ name: 'login', params: { locale: $lang.getLocale() } }">>{{ 'vue.log_in' | trans }}</router-link>
                            </li><li>
                                <router-link :to="{ name: 'register', params: { locale: $lang.getLocale() } }" class="btn">>{{ 'vue.register' | trans }}</router-link>
                            </li>
                        </template>
                        <a-divider></a-divider>
                        <li>
                            <a href="#" @click.prevent="setLocale('nl')">>{{ 'vue.nl' | trans }}</a>
                        </li><li>
                            <a href="#" @click.prevent="setLocale('fr')">>{{ 'vue.fr' | trans }}</a>
                        </li>
                    </ul>
                </nav>
            </Slide>
        </div>
    </header>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import { Slide } from 'vue-burger-menu';

    @Component({
        components: {
            Slide,
        }
    })
    export default class Header extends Vue {
        name: string = 'Header';
        appLink: string = (this as any).$auth.check('admin') ? 'judge-buddies' : 'dashboard';
        lang = (this as any).$lang;

        logout() {
            (this as any).$auth.logout({
                success: (response: any) => {
                    this.$message.success(this.lang.get('vue.log_out_success'));
                    this.$router.push({ name: 'home', params: { locale: this.lang.getLocale() } });
                },
                error: (error: any) => {
                    this.$message.error(this.lang.get('vue.something_went_wrong'));
                },
            });
        }

        setLocale(locale: string) {
            let url = window.location.href;

            if (locale == 'nl') {
                window.location.href = url.replace('fr', 'nl');
            }
            if (locale == 'fr') {
                window.location.href = url.replace('nl', 'fr');
            }
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
    @media screen and (max-width: 1200px) {
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

        a:not(.btn) {
            padding-bottom: 5px;
            position: relative;

            &:not(.router-link-active)::after {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                height: 1px;
                background: $light-color;
                content: '';
                opacity: 0;
                transition: height 0.3s, opacity 0.3s, transform 0.3s;
                transform: translateY(-10px);
            }
            &:not(.router-link-active):hover::after, &:not(.router-link-active):focus::after {
                height: 5px;
                opacity: 1;
                transform: translateY(0px);
            }
            &.router-link-active {
                border-bottom: 5px solid $light-color;
            }
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
    @media screen and (max-width: 1200px) {
        nav.desktop, nav.desktop + .langs {
            display: none;
        }
    }
</style>
