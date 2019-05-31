<template>
    <div>
        <template v-if="$auth.ready()">
            <div class="app">
                <Header></Header>
                <main>
                    <router-view></router-view>
                </main>
            </div>
        </template>
        <template v-else>
            <div class="wrapper">
                <h1>Een momentje...</h1>
            </div>
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
