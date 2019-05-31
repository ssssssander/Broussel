<template>
    <div class="login">
        <form @submit.prevent="login" class="fullscreen-form" method="post">
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
                <label for="email">E-mailadres</label>
                <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email" maxlength="255" autofocus>
            </div>
            <div class="form-block">
                <label for="password">Wachtwoord</label>
                <input v-model="formPassword" type="password" id="password" name="password" required autocomplete="current-password" maxlength="255">
            </div>
            <div class="form-block">
                <input type="checkbox" id="remember-me" v-model="rememberMe">
                <label for="remember-me"><span></span>Hou me ingelogd</label>
            </div>
            <div class="form-block">
                <input type="submit" value="Inloggen" class="btn" id="login-btn">
            </div>
        </form>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Login extends Vue {
        name: string = 'Login';
        formEmail: string = '';
        formPassword: string = '';
        rememberMe: boolean = false;
        errors: object = {};
        errorType: string = '';
        was422: boolean = false;

        mounted() {
            document.getElementById('email').focus();
        }

        login() {
            let loginBtnElem: any = document.getElementById('loigin-btn');

            if (this.was422) {
                for (let key of Object.keys(this.errors)) {
                    document.getElementsByName(key)[0].className = '';
                }
            }

            loginBtnElem.disabled = true;

            this.$auth.login({
                params: {
                    email: this.formEmail,
                    password: this.formPassword
                },
                success: (response: any) => {
                    loginBtnElem.disabled = false;
                    this.$message.success('Je bent met succes ingelogd!');
                },
                error: (error: any) => {
                    loginBtnElem.disabled = false;
                    this.$message.error('Niet alle velden zijn juist ingevuld!');

                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        for (let key of Object.keys(this.errors)) {
                            document.getElementsByName(key)[0].className = 'input-error';
                            this.was422 = true;
                        }
                    }
                    else if (error.response.data.error === 'login_error') {
                        this.errors = { 'login_error': ['Deze combinatie klopt niet!'] };
                    }
                    else {
                        this.errorType = error.response.status + ' ' + error.response.statusText;
                    }

                    document.getElementsByClassName('errors')[0].scrollIntoView();
                },
                rememberMe: this.rememberMe,
                fetchUser: true
            });
        }
    }
</script>

<style lang="scss" scoped>

</style>
