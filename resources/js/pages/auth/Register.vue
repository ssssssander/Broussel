<template>
    <div class="register">
        <Message
            message-type="error"
            :messages="errors"
            :extra-str="errorType"
        />
        <form @submit.prevent="register" method="post">
            <div class="form-block">
                <label for="name">{{ 'validation.attributes.name' | trans }}</label>
                <input v-model="formName" type="text" id="name" name="name" required autocomplete="name" maxlength="255" autofocus>
            </div>
            <div class="form-block">
                <label for="email">{{ 'validation.attributes.email' | trans }}</label>
                <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email" maxlength="255">
            </div>
            <div class="form-block">
                <label for="password">{{ 'validation.attributes.password' | trans }}<span class="side-text">{{ 'vue.at_least_chars' | trans({ chars: 8 }) }}</span></label>
                <input v-model="formPassword" type="password" id="password" name="password" required autocomplete="new-password" minlength="8" maxlength="255">
            </div>
            <div class="form-block">
                <label for="password_confirmation">{{ 'vue.type_password_again' | trans }}</label>
                <input v-model="formPasswordConfirmation" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" minlength="8" maxlength="255">
            </div>
            <div class="form-block">
                <LoadingButton :value="'vue.register' | trans" :loading="loading" />
            </div>
            <div class="form-block text-center">
                <router-link :to="{ name: 'login' }" class="link">{{ 'vue.already_have_account' | trans }}</router-link>
            </div>
        </form>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Register extends Vue {
        name: string = 'Register';
        lang = (this as any).$lang;
        formName: string = '';
        formEmail: string = '';
        formPassword: string = '';
        formPasswordConfirmation: string = '';
        errors: any = {};
        errorType: string = '';
        was422: boolean = false;
        loading: boolean = false;

        mounted() {
            document.getElementById('name').focus();
        }

        register() {
            if (this.loading) {
                return;
            }

            if (this.was422) {
                for (let key of Object.keys(this.errors)) {
                    document.getElementsByName(key)[0].className = '';
                    if (key == 'password') document.getElementsByName('password_confirmation')[0].className = '';
                }
            }

            this.loading = true;

            (this as any).$auth.register({
                data: {
                    name: this.formName,
                    email: this.formEmail,
                    password: this.formPassword,
                    password_confirmation: this.formPasswordConfirmation,
                },
                success: (response: any) => {
                    (this as any).$auth.login({
                        data: {
                            email: this.formEmail,
                            password: this.formPassword,
                        },
                        success: (response: any) => {
                            this.$message.success(this.lang.get('vue.register_success'));
                            this.$router.push({ name: 'dashboard' });
                        },
                        error: (error: any) => {
                            this.$router.push({ name: 'login' });
                        },
                        rememberMe: false,
                        fetchUser: true
                    });
                },
                error: (error: any) => {
                    this.loading = false;
                    this.$message.error(this.lang.get('vue.not_all_fields_correct'));

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

                    document.getElementsByTagName('h1')[0].scrollIntoView();
                },
            });
        }
    }
</script>

<style lang="scss" scoped>

</style>
