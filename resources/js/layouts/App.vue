<template>
    <div class="app">
        <Header></Header>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import Header from "../components/Header.vue";
    @Component({
        components: {Header}
    })
    export default class App extends Vue {
        name: string = 'App';
    }
</script>

<style lang="scss" scoped>

</style>
