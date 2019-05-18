<template>
    <div class="bg">
        <slot></slot>
        <div class="hero">
            <div class="wrapper">
                <div class="hero-text">
                    <h1>Ontdek het groen in Brussel</h1>
                    <p>Vind gidsen met expertise die je one-on-one begeleiden en ontdek unieke natuurroutes in Brussel</p>
                </div>
                <div class="r">
                    <img src="../../../public/img/n.jpg" alt="">
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

        .wrapper {
            justify-content: space-between;
        }
        .r {
            width: 40%;
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
