<template>
    <div :class="[appBackgroundClass, 'app']">
        <Header :class="headerBackgroundClass"></Header>
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    import Header from "../components/Header.vue";
    @Component({
        components: {Header}
    })
    export default class App extends Vue {
        name: string = 'App';
        backgroundPages: string[] = ['contact'];

        get appBackgroundClass() {
            let returnVal;
            if (this.$route.name == 'home') {
                returnVal = {
                    'bg-svg': true,
                }
            }
            else if (this.backgroundPages.indexOf(this.$route.name) === -1) {
                returnVal = {
                    'bg-gradient': true,
                }
            }
            return returnVal;
        }

        get headerBackgroundClass() {
            let returnVal;
            if (this.backgroundPages.indexOf(this.$route.name) > -1) {
                returnVal = {
                    'bg-gradient': true,
                }
            }
            return returnVal;
        }
    }
</script>

<style lang="scss" scoped>
    /*.app {*/
    /*    display: flex;*/
    /*    flex-flow: column nowrap;*/
    /*    height: 100%;*/
    /*}*/
    /*main {*/
    /*    flex-grow : 1;;*/
    /*}*/
</style>
