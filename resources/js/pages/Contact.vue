<template>
    <div class="contact">
        <h1>{{ 'vue.contact_us' | trans }}</h1>
        <a-divider></a-divider>
        <p>{{ 'vue.contact_us_text' | trans }} <a href="mailto:contact@broussel.be" class="link">contact@broussel.be</a></p>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Contact extends Vue {
        name: string = 'Contact';
    }
</script>

<style lang="scss" scoped>

</style>
