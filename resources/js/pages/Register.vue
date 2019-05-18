<template>
    <div>
        <form method="POST" @submit.prevent="register">
            <label for="name">Naam</label>
            <input v-model="formName" type="text" id="name" name="name" required autocomplete="name" autofocus>
            <label for="email">E-mailadres</label>
            <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email">
            <label for="password">Wachtwoord</label>
            <input v-model="formPassword" type="password" id="password" name="password" required autocomplete="new-password">
            <label for="password_confirmation">Typ je wachtwoord opnieuw</label>
            <input v-model="formPasswordConfirmation" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            <input type="submit" value="Registreren">
        </form>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import axios from 'axios';

    @Component
    export default class Register extends Vue {
        name: string = 'Register';
        formName: string = '';
        formEmail: string = '';
        formPassword: string = '';
        formPasswordConfirmation: string = '';

        register() {
            axios.post('/dothing', {
                name: this.formName,
                email: this.formEmail,
                password: this.formPassword,
                password_confirmation: this.formPasswordConfirmation,
            })
            .then(function (response: any) {
                console.log(response);
            })
            .catch(function (error: any) {
                console.log(error);
            });
        }
    }
</script>

<style lang="scss" scoped>

</style>
