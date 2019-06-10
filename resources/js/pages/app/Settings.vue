<template>
    <div class="settings">
        <p>Change data</p>
        <p>Profile pic</p>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class Settings extends Vue {
        name: string = 'Settings';
    }
</script>

<style lang="scss" scoped>
    
</style>
