<template>
    <div>
        <p>Contact</p>
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
    div {
        p {
            color: $blue;
            font-family: 'Delius Unicase', cursive;
        }
    }
</style>
