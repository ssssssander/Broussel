<template>
    <div class="hero">
        <div class="wrapper">
            <div class="hero-text">
                <h1>Ontdek het groen in Brussel</h1>
                <p>Vind wandelbuddies met expertise die je one-on-one begeleiden en ontdek unieke natuurroutes in Brussel.</p>
                <div class="buttons">
                    <router-link :to="{ name: 'register' }" class="btn btn-start">Begin nu</router-link>
                    <router-link :to="{ name: 'register' }" class="link">Of wordt een wandelbuddy →</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Hero extends Vue {
        name: string = 'Hero'
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
        margin-top: 40px;
        display: flex;
        align-items: center;

        .btn-start {
            width: 50%;
            margin-right: 20px;
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
        max-width: 55%;
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
</style>
