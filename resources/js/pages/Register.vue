<template>
    <div class="register">
        <form @submit.prevent="register">
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

            axios.post('/register', {
                name: this.formName,
                email: this.formEmail,
                password: this.formPassword,
                password_confirmation: this.formPasswordConfirmation,
            })
            .then((response: any) => {
                this.$router.replace({ name: 'app-home' });
                console.log(response);
                clear();
            })
            .catch((error: any)=> {
                console.log(error.response);
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
                clear();
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
    .register {
        padding: 60px 0;
    }
    form {
        margin: 0 auto;
        width: 60%;
        max-width: 500px;
        padding: 30px;
        border-radius: $default-border-radius;
        background-color: $secondary-color;
        box-shadow: 0 2px 4px 0 rgba(14, 30, 37, 0.12);

        label, input {
            display: block;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 2px solid #e9ebeb;
            border-radius: $default-border-radius;
            margin: 5px 0;

            &:focus {
                border: 2px solid $green;
            }
        }
        input[type="submit"] {
            width: 100%;
        }
        .form-block {
            margin-top: 10px;
        }
        .side-text {
            margin-left: 10px;
            font-size: 0.6em;
            color: grayscale(lighten($primary-color, 30%));
        }
        .errors {
            padding: 15px;
            background-color: $error-color;
            color: $secondary-color;
            border-radius: $default-border-radius;

            li, span {
                display: block;
                margin: 5px 0;
            }
        }
    }
</style>
