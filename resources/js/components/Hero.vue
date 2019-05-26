<template>
    <div class="hero">
        <div class="wrapper">
            <div class="hero-text">
                <h1>Ontdek het groen in Brussel</h1>
                <p>Vind wandelbuddies met expertise die je one-on-one begeleiden en ontdek unieke natuurroutes in Brussel</p>
                <div class="buttons">
                    <router-link :to="{ name: 'register' }" class="btn btn-start">Begin nu</router-link>
                    <router-link :to="{ name: 'register' }" class="btn btn-small">Of wordt een wandelbuddy</router-link>
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
        padding: 60px 0 200px 0;

        .buttons {
            margin-top: 40px;
            display: flex;
            align-items: flex-end;

            .btn-start {
                width: 50%;
                margin-right: 20px;
            }
        }
        .wrapper {
            justify-content: space-between;
        }
        img {
            width: 100%;
            height: auto;
            border-radius: 1%;
        }
        .hero-text {
            color: $secondary-color;
            display: inline-block;
            max-width: 55%;
            text-shadow: 0 2px 20px rgba(0,0,0,.16);

            h1, p {
                line-height: 1.2;
            }
            h1 {
                font-size: 4em;
                margin: 0 0 20px 0;
                line-height: 1.2;
            }
            p {
                font-size: 1.2em;
                line-height: 1.2;
            }
        }
    }
</style>
