<template>
    <div class="fullscreen-form">
        <h1>{{ $route.meta['title_' + $lang.getLocale()] }}</h1>
        <router-view></router-view>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class Auth extends Vue {
        name: string = 'Auth';
    }
</script>

<style lang="scss" scoped>
    
</style>
