<template>
    <div class="bg">
        <slot></slot>
        <div class="hero">
            <div class="wrapper">
                <div class="hero-text">
                    <h1>Ontdek het groen in Brussel</h1>
                    <p>Vind gidsen met expertise die je one-on-one begeleiden en ontdek unieke natuurroutes in Brussel</p>
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
        padding: 20px 0 60px 0;

        .hero-text {
            color: $secondary-color;
            line-height: initial;
            display: inline-block;
            max-width: 55%;

            h1 {
                font-size: 4em;
                margin: 0 0 20px 0;
            }
            p {
                font-size: 1.2em;
            }
        }
    }
</style>
