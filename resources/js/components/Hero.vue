<template>
    <div class="hero">
        <div class="hero-text">
            <h1>{{ 'vue.hero_title' | trans }}</h1>
            <p>{{ 'vue.hero_text' | trans }}</p>
            <div class="buttons">
                <router-link :to="{ name: beginLink, params: { locale: $lang.getLocale() } }" class="btn">{{ 'vue.start_now' | trans }}</router-link>
                <router-link :to="{ name: 'register-buddy', params: { locale: $lang.getLocale() } }" class="link">{{ 'vue.or_become_walking_buddy' | trans }}</router-link>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Hero extends Vue {
        name: string = 'Hero';
        beginLink: string = (this as any).$auth.check() ? (this as any).$auth.check('admin') ? 'judge-buddies' : 'dashboard' : 'register';
    }
</script>

<style lang="scss" scoped>
    .hero {
        padding-bottom: 80px;
    }
    .link {
        color: $light-color;
    }

    .buttons {
        margin-top: 30px;
        display: flex;
        align-items: center;

        .btn {
            width: 50%;
            margin-right: 20px;
        }
        .btn, .link {
            min-width: 100px;
        }
    }
    .wrapper {
        display: flex;
        justify-content: space-between;
    }
    img {
        width: 100%;
        height: auto;
        border-radius: 1%;
    }
    .hero-text {
        color: $light-color;
        display: inline-block;
        max-width: 65%;
        text-shadow: $text-shadow;

        h1, p {
            line-height: 1.2;
        }
        h1 {
            font-size: 4em;
            font-weight: bold;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        p {
            font-size: 1.2em;
            line-height: 1.2;
        }
    }
    @media screen and (max-width: 900px) {
        .hero-text {
            h1 {
                font-size: 3em;
            }
        }
    }
    @media screen and (max-width: 1180px) {
        .hero-text {
            h1 {
                font-size: 3.5em;
            }
        }
    }
</style>
