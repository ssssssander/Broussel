<template>
    <div class="forgot-password">
        <div class="fullscreen-form">
            <h1>Wachtwoord vergeten?</h1>
            <form @submit.prevent="sendResetLink" method="post">
                <div class="form-block">
                    <label for="email">E-mailadres</label>
                    <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email" maxlength="255" autofocus>
                </div>
                <div class="form-block">
                    <LoadingButton value="Mail versturen" :loading="loading" />
                </div>
            </form>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class ForgotPassword extends Vue {
        name: string = 'ForgotPassword';
        formEmail: string = '';
        loading: boolean = false;

        sendResetLink() {
            this.loading = true;

            this.$http({
                url: `auth/forgot-password`,
                method: 'post',
                data: {
                    email: this.formEmail,
                },
            })
            .then((response: any) => {
                this.$message.success('Mail verstuurd!');
                this.$router.replace({ name: 'home' });
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
