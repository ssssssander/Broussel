<template>
    <div class="forgot-password">
        <div class="fullscreen-form">
            <h1>Wachtwoord resetten</h1>
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
        loading: boolean = false;

        created() {
            if (!this.$route.query.token || !this.$route.query.email) {
                this.$router.replace({ name: 'error404' });
            }
            else {
                this.formEmail = this.$route.query.email.toString();
            }
        }

        resetPassword() {
            this.loading = true;

            this.$http({
                url: `auth/reset-password`,
                method: 'post',
                data: {
                    token: this.$route.query.token,
                    email: this.$route.query.email,
                    password: this.formPassword,
                    password_confirmation: this.formPasswordConfirmation,
                },
            })
            .then((response: any) => {
                console.log(response);
            }, (error: any) => {
                console.log(error.response);
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
