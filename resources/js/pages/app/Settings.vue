<template>
    <div class="settings">
        <h2>Stel je profielfoto in</h2>
        <form enctype="multipart/form-data" @submit.prevent="uploadAvatar" method="post">
            <input type="file" id="file" ref="file" @change="handleFileUpload">
            <LoadingButton value="Uploaden" :loading="uploadAvatarLoading" />
        </form>
        <a-divider />
        <h2>Verander je informatie</h2>
        <form @submit.prevent="changeInfo" method="post">
            <div class="form-block">
                <label for="name">Naam</label>
                <input v-model="formName" type="text" id="name" name="name" required autocomplete="name" maxlength="255">
            </div>
            <div class="form-block">
                <label for="email">E-mailadres</label>
                <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email" maxlength="255">
            </div>
            <div class="form-block">
                <LoadingButton value="Aanpassen" :loading="changeInfoLoading" />
            </div>
        </form>
        <a-divider />
        <h2>Verander je wachtwoord</h2>
        <form @submit.prevent="changePassword" method="post">
            <div class="form-block">
                <label for="password">Wachtwoord<span class="side-text">Minstens 8 tekens</span></label>
                <input v-model="formPassword" type="password" id="password" name="password" required autocomplete="new-password" minlength="8" maxlength="255">
            </div>
            <div class="form-block">
                <label for="password_confirmation">Typ je wachtwoord opnieuw</label>
                <input v-model="formPasswordConfirmation" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" minlength="8" maxlength="255">
            </div>
            <div class="form-block">
                <LoadingButton value="Aanpassen" :loading="changePasswordLoading" />
            </div>
        </form>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class Settings extends Vue {
        name: string = 'Settings';
        file: any = '';
        uploadAvatarLoading: boolean = false;
        changeInfoLoading: boolean = false;
        changePasswordLoading: boolean = false;
        formName: string = '';
        formEmail: string = '';
        formPassword: string = '';
        formPasswordConfirmation: string = '';

        mounted() {
            let nameInputElem: any = document.getElementById('name');
            let emailInputElem: any = document.getElementById('email');
            nameInputElem.value = (this as any).$auth.user().name;
            emailInputElem.value = (this as any).$auth.user().email;
        }

        uploadAvatar() {
            this.uploadAvatarLoading = true;
            let formData = new FormData();
            formData.append('file', this.file);

            this.$http({
                url: `auth/upload-avatar`,
                method: 'post',
                data: formData,
            })
            .then((response: any) => {
                this.$message.success('Profielfoto geüpload!');
            }, (error: any) => {
                this.$message.error('Er is iets misgegaan');
            })
            .then(() => {
                this.uploadAvatarLoading = false;
            });
        }

        handleFileUpload() {
            let file: any = this.$refs.file;
            this.file = file.files[0];
        }

        changeInfo() {

        }

        changePassword() {

        }
    }
</script>

<style lang="scss" scoped>
    
</style>
