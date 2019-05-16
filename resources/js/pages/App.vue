<template>
    <div>
        <nav>
            <router-link :to="{ name: 'home' }">Home</router-link>
            <router-link :to="{ name: 'contact' }" >Contact</router-link>
        </nav>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script lang="ts">
    export default {
        name: 'App',
    }
</script>

<style lang="scss">
    // Global Sass
    @import url('https://fonts.googleapis.com/css?family=Delius+Unicase');

    * {
        box-sizing: border-box;
    }
</style>
