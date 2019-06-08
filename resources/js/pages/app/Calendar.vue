<template>
    <div class="calendar">
        <h1>Kalender</h1>
        <a-calendar @panelChange="onPanelChange" @select="onSelect" />
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class Calendar extends Vue {
        name: string = 'Calendar';

        onPanelChange(value: any, mode: any) {
            console.log(value, mode);
        }

        onSelect(value: any) {
            console.log(value);
        }
    }
</script>

<style lang="scss" scoped>
    
</style>
