<template>
    <div class="register fullscreen">
        <form @submit.prevent="register" class="fullscreen-form" method="post">
            <div v-show="Object.keys(errors).length" class="errors">
                <ul>
                    <li v-for="errorArr in errors">
                        <span v-for="error in errorArr">
                            {{ error }}
                        </span>
                    </li>
                </ul>
            </div>
            <div class="form-block">
                <label for="name">Naam</label>
                <input v-model="formName" type="text" id="name" name="name" required autocomplete="name" autofocus>
            </div>
            <div class="form-block">
                <label for="email">E-mailadres</label>
                <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email">
            </div>
            <div class="form-block">
                <label for="password">Wachtwoord<span class="side-text">Minstens 8 tekens</span></label>
                <input v-model="formPassword" type="password" id="password" name="password" required autocomplete="new-password">
            </div>
            <div class="form-block">
                <label for="password_confirmation">Typ je wachtwoord opnieuw</label>
                <input v-model="formPasswordConfirmation" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            </div>
            <div class="form-block">
                <input type="submit" value="Registreren" class="btn" id="register-btn">
            </div>
            <div class="form-block center">
                <router-link :to="{ name: 'login' }" class="link">Heb je al een account? Log hier in.</router-link>
            </div>
        </form>
        <form @submit.prevent="logout">
            <input type="submit" value="Uitloggen">
        </form>
    </div>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';

    @Component
    export default class Register extends Vue {
        name: string = 'Register';
        formName: string = '';
        formEmail: string = '';
        formPassword: string = '';
        formPasswordConfirmation: string = '';
        errors: object = {};

        mounted() {
            document.getElementById('name').focus();
        }

        register() {
            function clear() {
                window.clearInterval(loadingInterval);
                document.getElementById('register-btn').setAttribute('value', 'Registreren');
            }

            let i = 0;
            let loadingInterval = window.setInterval(() => {
                document.getElementById('register-btn').setAttribute('value', 'We zijn er mee bezig' + '.'.repeat(i++));
                if (i > 3) i = 0;
            }, 200);

            this.axios.post('/register', {
                name: this.formName,
                email: this.formEmail,
                password: this.formPassword,
                password_confirmation: this.formPasswordConfirmation,
            })
            .then((response: any) => {
                clear();
                this.$router.replace({ name: 'dashboard' });
            })
            .catch((error: any)=> {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
                clear();
            });
        }

        logout() {
            this.axios.post('/logout')
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
    .center {
        text-align: center;
    }
</style>
