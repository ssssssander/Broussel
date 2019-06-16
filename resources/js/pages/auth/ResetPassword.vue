<template>
    <div class="forgot-password">
        <form @submit.prevent="resetPassword" method="post">
            <div class="form-block">
                <label for="password">Wachtwoord<span class="side-text">Minstens 8 tekens</span></label>
                <input v-model="formPassword" type="password" id="password" name="password" required autocomplete="new-password" minlength="8" maxlength="255">
            </div>
            <div class="form-block">
                <label for="password_confirmation">Typ je wachtwoord opnieuw</label>
                <input v-model="formPasswordConfirmation" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" minlength="8" maxlength="255">
            </div>
            <div class="form-block">
                <LoadingButton value="Aanpassen" :loading="loading" />
            </div>
        </form>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class ResetPassword extends Vue {
        name: string = 'ResetPassword';
        formEmail: string = '';
        formPassword: string = '';
        formPasswordConfirmation: string = '';
        queryToken: string = '';
        queryEmail: string = '';
        loading: boolean = false;

        created() {
            if (!this.$route.query.token || !this.$route.query.email) {
                this.$router.replace({ name: 'error404' });
            }
            else {
                this.queryToken = this.$route.query.token.toString();
                this.queryEmail = this.$route.query.email.toString();
                this.formEmail = this.queryEmail;
            }
        }

        resetPassword() {
            this.loading = true;

            this.$http({
                url: `auth/reset-password`,
                method: 'post',
                data: {
                    password: this.formPassword,
                    password_confirmation: this.formPasswordConfirmation,
                    email: this.queryEmail,
                    token: this.queryToken,
                },
            })
            .then((response: any) => {
                (this as any).$auth.login({
                    data: {
                        email: this.queryEmail,
                        password: this.formPassword,
                    },
                    success: (response: any) => {
                        this.$message.success('Je wachtwoord is aangepast!');
                        this.$router.replace({ name: 'home' });
                    },
                    error: (error: any) => {
                        this.$router.replace({ name: 'login' });
                    },
                    rememberMe: false,
                    fetchUser: true
                });
            }, (error: any) => {
                this.$message.error('Er is iets misgegaan');
            })
            .then(() => {
                this.loading = false;
            });
        }
    }
</script>

<style lang="scss" scoped>
    
</style>
