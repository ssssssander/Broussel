<template>
    <div class="contact">
        <h1>Contacteer ons</h1>
        <a-divider></a-divider>
        <h1>h1 Heading</h1>
        <h2>h2 Heading</h2>
        <h3>h3 Heading</h3>
        <h4>h4 Heading</h4>
        <h5>h5 Heading</h5>
        <h6>h6 Heading</h6>
        <p>Paragraaf</p>
        <p>Paragraaf</p>
        <p>Paragraaf</p>
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
