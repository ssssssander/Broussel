<template>
    <div class="login">
        <div class="fullscreen-form">
            <h1>Log in</h1>
            <Message
                message-type="error"
                :messages="errors"
                :extra-str="errorType"
            />
            <form @submit.prevent="login" method="post">
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
                    <label for="remember-me"><span class="checkbox"></span>Hou me ingelogd</label>
                </div>
                <div class="form-block">
                    <LoadingButton value="Inloggen" :loading="loading" />
                </div>
            </form>
        </div>
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
        errors: any = {};
        errorType: string = '';
        was422: boolean = false;
        loading: boolean = false;

        mounted() {
            document.getElementById('email').focus();
        }

        login() {
            if (this.loading) {
                return;
            }

            if (this.was422) {
                for (let key of Object.keys(this.errors)) {
                    document.getElementsByName(key)[0].className = '';
                }
            }

            this.loading = true;

            (this as any).$auth.login({
                data: {
                    email: this.formEmail,
                    password: this.formPassword,
                },
                success: (response: any) => {
                    this.$message.success('Je bent met succes ingelogd!');
                    if ((this as any).$auth.user().role == 3) {
                        this.$router.push({ name: 'judge-buddies' });
                    }
                    else {
                        this.$router.push({ name: 'dashboard' });
                    }
                },
                error: (error: any) => {
                    this.loading = false;
                    this.$message.error('Niet alle velden zijn juist ingevuld.');

                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        for (let key of Object.keys(this.errors)) {
                            document.getElementsByName(key)[0].className = 'input-error';
                            this.was422 = true;
                        }
                    }
                    else if (error.response.data.error === 'login_error') {
                        this.errors = { 'login_error': ['Deze combinatie klopt niet.'] };
                    }
                    else {
                        this.errorType = error.response.status + ' ' + error.response.statusText;
                    }

                    document.getElementsByTagName('h1')[0].scrollIntoView();
                },
                rememberMe: this.rememberMe,
                fetchUser: true
            });
        }
    }
</script>

<style lang="scss" scoped>

</style>
