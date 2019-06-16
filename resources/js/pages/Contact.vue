<template>
    <div class="contact">
        <h1>Contacteer ons</h1>
        <a-divider></a-divider>
        <p>Opmerkingen? Vragen? Feedback? Contacteer ons op <a href="mailto:contact@broussel.be" class="link">contact@broussel.be</a></p>
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
