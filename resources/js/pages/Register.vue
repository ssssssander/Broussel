<template>
    <div class="register">
        <form @submit.prevent="register" class="fullscreen-form" method="post">
            <div v-show="Object.keys(errors).length || errorType" class="errors">
                <ul>
                    <li>
                        <span>{{ errorType }}</span>
                    </li>
                    <li v-for="errorArr in errors">
                        <span v-for="error in errorArr">
                            {{ error }}
                        </span>
                    </li>
                </ul>
            </div>
            <div class="form-block">
                <label for="name">Naam</label>
                <input v-model="formName" type="text" id="name" name="name" required autocomplete="name" maxlength="255" autofocus>
            </div>
            <div class="form-block">
                <label for="email">E-mailadres</label>
                <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email" maxlength="255">
            </div>
            <div class="form-block">
                <label for="password">Wachtwoord<span class="side-text">Minstens 8 tekens</span></label>
                <input v-model="formPassword" type="password" id="password" name="password" required autocomplete="new-password" maxlength="255">
            </div>
            <div class="form-block">
                <label for="password_confirmation">Typ je wachtwoord opnieuw</label>
                <input v-model="formPasswordConfirmation" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" maxlength="255">
            </div>
            <div class="form-block">
                <input type="submit" value="Registreren" class="btn" id="register-btn">
            </div>
            <div class="form-block text-center">
                <router-link :to="{ name: 'login' }" class="link">Heb je al een account? Log hier in.</router-link>
            </div>
        </form>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Register extends Vue {
        name: string = 'Register';
        formName: string = '';
        formEmail: string = '';
        formPassword: string = '';
        formPasswordConfirmation: string = '';
        errors: object = {};
        errorType: string = '';
        was422: boolean = false;

        mounted() {
            document.getElementById('name').focus();
        }

        register() {
            let registerBtnElem: any = document.getElementById('register-btn');

            if (this.was422) {
                for (let key of Object.keys(this.errors)) {
                    document.getElementsByName(key)[0].className = '';
                    if (key == 'password') document.getElementsByName('password_confirmation')[0].className = '';
                }
            }

            registerBtnElem.disabled = true;

            this.$auth.register({
                data: {
                    name: this.formName,
                    email: this.formEmail,
                    password: this.formPassword,
                    password_confirmation: this.formPasswordConfirmation,
                },
                success: (response: any) => {
                    registerBtnElem.disabled = false;
                    this.$message.success('Je bent met succes geregistreerd!');
                },
                error: (error: any) => {
                    registerBtnElem.disabled = false;
                    this.$message.error('Niet alle velden zijn juist ingevuld!');

                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        for (let key of Object.keys(this.errors)) {
                            document.getElementsByName(key)[0].className = 'input-error';
                            if (key == 'password') document.getElementsByName('password_confirmation')[0].className = 'input-error';
                            this.was422 = true;
                        }
                    }
                    else {
                        this.errorType = error.response.status + ' ' + error.response.statusText;
                    }

                    document.getElementsByClassName('errors')[0].scrollIntoView();
                },
            });
        }
    }
</script>

<style lang="scss" scoped>

</style>
