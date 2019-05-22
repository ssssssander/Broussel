<template>
    <div>
        <div v-show="errors" class="errors">
            <ul>
                <li v-for="errorArr in errors">
                    <span v-for="error in errorArr">
                        {{ error }}
                    </span>
                </li>
            </ul>
        </div>
        <form @submit.prevent="register">
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
        <form @submit.prevent="logout">
            <input type="submit" value="Uitloggen">
        </form>
    </div>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    import axios from 'axios';

    @Component
    export default class Register extends Vue {
        @Prop(Boolean) isAuth: boolean;

        name: string = 'Register';
        formName: string = '';
        formEmail: string = '';
        formPassword: string = '';
        formPasswordConfirmation: string = '';
        errors: object = {};

        register() {
            axios.post('/register', {
                name: this.formName,
                email: this.formEmail,
                password: this.formPassword,
                password_confirmation: this.formPasswordConfirmation,
            })
            .then((response: any) => {
                // this.$router.replace({ name: 'home' });
                console.log(response);

                axios.post('/poll-auth')
                .then((response: any) => {
                    console.log(response);
                    this.isAuth = response.data;
                });
            })
            .catch((error: any)=> {
                console.log(error.response);
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        }

        logout() {
            axios.post('/logout')
            .then((response: any) => {
                // this.$router.replace({ name: 'home' });
                console.log(response);
            })
            .catch((error: any)=> {
                console.log(error.response.data.errors);
            });
        }
    }
</script>

<style lang="scss" scoped>

</style>
