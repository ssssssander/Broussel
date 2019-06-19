<template>
    <div class="home">
        <Hero></Hero>
        <div class="content">
            <h2>{{ 'vue.how_it_works' | trans }}</h2>
            <a-divider></a-divider>
            <div class="steps">
                <div class="step">
                    <h3>{{ 'vue.home_step1_title' | trans }}</h3>
                    <p>{{ 'vue.home_step1_p1' | trans }}</p>
                    <p>{{ 'vue.home_step1_p2' | trans }}</p>
                </div>
                <div class="step">
                    <h3>{{ 'vue.home_step2_title' | trans }}</h3>
                    <p>{{ 'vue.home_step2_p1' | trans }}</p>
                    <p>{{ 'vue.home_step2_p2' | trans }}</p>
                </div>
                <div class="step">
                    <h3>{{ 'vue.home_step3_title' | trans }}</h3>
                    <p>{{ 'vue.home_step3_p1' | trans }}</p>
                    <p>{{ 'vue.home_step3_p2' | trans }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Home extends Vue {
        name: string = 'Home';
    }
</script>

<style lang="scss" scoped>
    .content {
        margin-top: 200px;

        h2 {
            font-size: 3em;
            text-align: center;
        }

        .steps {
            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            margin-top: 50px;

            .step {
                margin: 10px;
                text-align: center;
                min-width: 260px;
                width: 30%;
                border: $light-border;
                padding: 30px;
                border-radius: $default-border-radius;
                box-shadow: $box-shadow;

                h3 {
                    margin-bottom: 10px;
                }
            }
        }
    }
</style>
