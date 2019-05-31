<template>
    <div class="app">
        <template v-if="$auth.ready()">
            <Header></Header>
            <main>
                <router-view></router-view>
            </main>
        </template>
    </div>
</template>

<script lang="ts">
    import { Component, Vue, Watch} from 'vue-property-decorator';

    @Component
    export default class App extends Vue {
        name: string = 'App';
    }
</script>

<style lang="scss" scoped>
    h1 {
        color: $light-color;
    }
</style>
