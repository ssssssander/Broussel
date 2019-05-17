<template>
    <div>Whaddup</div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import Header from '../components/Header.vue';
    import Hero from '../components/Hero.vue';

    @Component({
        components: {
            Hero,
        }
    })
    export default class Home extends Vue {
        name: string = 'Home';
    }
</script>

<style lang="scss" scoped>

</style>
