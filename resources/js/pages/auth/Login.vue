<template>
    <div class="login">
        <Message
            message-type="error"
            :messages="errors"
            :extra-str="errorType"
        />
        <form @submit.prevent="login" method="post">
            <div class="form-block">
                <label for="email">{{ 'validation.attributes.email' | trans }}</label>
                <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email" maxlength="255" autofocus>
            </div>
            <div class="form-block">
                <label for="password">{{ 'validation.attributes.password' | trans }}</label>
                <input v-model="formPassword" type="password" id="password" name="password" required autocomplete="current-password" maxlength="255">
            </div>
            <div class="form-block">
                <input type="checkbox" id="remember-me" v-model="rememberMe">
                <label for="remember-me"><span class="checkbox"></span>{{ 'vue.keep_me_logged_in' | trans }}</label>
            </div>
            <div class="form-block">
                <LoadingButton :value="'vue.log_in' | trans" :loading="loading" />
            </div>
            <div class="form-block text-center">
                <router-link :to="{ name: 'forgot-password' }" class="link">{{ 'vue.forgot_password' | trans }}</router-link>
            </div>
        </form>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Login extends Vue {
        name: string = 'Login';
        lang = (this as any).$lang;
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
                    this.$message.success(this.lang.get('vue.login_success'));
                    if ((this as any).$auth.user().role == 'admin') {
                        this.$router.push({ name: 'judge-buddies' });
                    }
                    else {
                        this.$router.push({ name: 'dashboard' });
                    }
                },
                error: (error: any) => {
                    this.loading = false;
                    this.$message.error(this.lang.get('vue.not_all_fields_correct'));

                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        for (let key of Object.keys(this.errors)) {
                            document.getElementsByName(key)[0].className = 'input-error';
                            this.was422 = true;
                        }
                    }
                    else if (error.response.data.error === 'login_error') {
                        this.errors = { 'login_error': [this.lang.get('vue.wrong_combination')] };
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
