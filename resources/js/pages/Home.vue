<template>
    <div class="home">
        <Hero></Hero>
        <div class="content">
            <h2>Hoe het werkt</h2>
            <a-divider></a-divider>
            <div class="steps">
                <div class="step">
                    <h3>Kies je tijdstip</h3>
                    <p>Kies een dag en het van en tot tijstip waarop je wil wandelen.</p>
                    <p>Dit kan op de huidige dag en al 20 minuten op voorhand!</p>
                </div>
                <div class="step">
                    <h3>Kies je wandelbudddy</h3>
                    <p>Kies uit alle beschikbare wandelbuddies op jouw tijdstip en kies er een naar jouw keuze.</p>
                    <p>Of zoek op naam als je al iemand kent!</p>
                </div>
                <div class="step">
                    <h3>Spreek af</h3>
                    <p>Begin te chatten met je gekozen wandelbuddy en spreek af.</p>
                    <p>Vertel wat voor route je wil en je wandelbuddy maakt het waar, hij/zij is immers een expert in de Brusselse natuur.</p>
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
