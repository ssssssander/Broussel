<template>
    <div class="forgot-password">
        <form @submit.prevent="sendResetLink" method="post">
            <div class="form-block">
                <label for="email">{{ 'validation.attributes.email' | trans }}</label>
                <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email" maxlength="255" autofocus>
            </div>
            <div class="form-block">
                <LoadingButton :value="'vue.send_mail' | trans" :loading="loading" />
            </div>
        </form>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class ForgotPassword extends Vue {
        name: string = 'ForgotPassword';
        lang = (this as any).$lang;
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
                this.$message.success(this.lang.get('vue.mail_sent'));
                this.$router.replace({ name: 'home' });
            }, (error: any) => {
                this.$message.error(this.lang.get('vue.something_went_wrong'));
            })
            .then(() => {
                this.loading = false;
            });
        }
    }
</script>

<style lang="scss" scoped>
    
</style>
