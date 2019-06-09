<template>
    <div class="faq">
        <h1>FAQ</h1>
        <a-divider></a-divider>
        <a-collapse :bordered="false">
            <a-collapse-panel header="Wat zijn de tarieven?" key="1">
                <p>Een wandelbuddy boeken kost altijd 12 euro per uur, 5% van het totale bedrag per boeking gaat naar Broussel, de rest naar de wandelbuddy.</p>
            </a-collapse-panel>
            <a-collapse-panel header="Wanneer kan ik met iemand wandelen?" key="2">
                <p>Je kan op elke datum en tijdstip met iemand wandelen zolang er iemand beschikbaar is op je gekozen datum en tijdstip.</p>
            </a-collapse-panel>
            <a-collapse-panel header="Kan ik op dezelfde dag nog een wandeling boeken?" key="3">
                <p>Ja, dat kan zelfs al 20 minuten op voorhand.</p>
            </a-collapse-panel>
        </a-collapse>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class FAQ extends Vue {
        name: string = 'FAQ';
    }
</script>

<style lang="scss">
    .ant-collapse {
        font-size: 1em;
    }
    .ant-collapse > .ant-collapse-item > .ant-collapse-header {
        padding: 20px 0 20px 40px;
    }
</style>

<style lang="scss" scoped>
    
</style>
