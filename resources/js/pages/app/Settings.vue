<template>
    <div class="settings">
        <h3>Stel je profielfoto in</h3>
        <Message
            message-type="error"
            :messages="errors"
            :extra-str="errorType"
        />
        <form enctype="multipart/form-data" @submit.prevent="uploadAvatar" method="post">
            <div class="form-block">
                <div class="file-area">
                    <input type="file" id="file" ref="file" name="file" @change="handleFileUpload">
                    <label for="file" class="btn"><a-icon type="upload" />Kies een profielfoto</label>
                </div>
                <LoadingButton value="Uploaden" :loading="uploadAvatarLoading" />
            </div>
        </form>
        <a-divider />
        <h3>Verander je informatie</h3>
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
        <h3>Verander je wachtwoord</h3>
        <form @submit.prevent="changePassword" method="post">
            <div class="form-block">
                <label for="old_password">Huidig wachtwoord</label>
                <input v-model="formOldPassword" type="password" id="old_password" name="old_password" required autocomplete="current-password" maxlength="255">
            </div>
            <div class="form-block">
                <label for="password">Nieuw wachtwoord<span class="side-text">Minstens 8 tekens</span></label>
                <input v-model="formPassword" type="password" id="password" name="password" required autocomplete="new-password" minlength="8" maxlength="255">
            </div>
            <div class="form-block">
                <label for="password_confirmation">Typ je nieuw wachtwoord opnieuw</label>
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
        formOldPassword: string = '';
        formPassword: string = '';
        formPasswordConfirmation: string = '';
        errors: any = {};
        errorType: string = '';
        was422: boolean = false;

        created() {
            this.formName = (this as any).$auth.user().name;
            this.formEmail = (this as any).$auth.user().email;
        }

        uploadAvatar() {
            if (this.file == '') {
                return;
            }

            this.uploadAvatarLoading = true;
            this.removeErrors();
            let formData = new FormData();
            formData.append('file', this.file);

            this.$http({
                url: `auth/upload-avatar`,
                method: 'post',
                data: formData,
            })
            .then((response: any) => {
                (this as any).$auth.fetch();
                this.$message.success('Profielfoto geüpload!');
            }, (error: any) => {
                this.$message.error('Er is iets misgegaan');
                this.setErrors(error);
                if (this.errorType) {
                    this.errorType = 'Bestand kon niet worden geüpload.';
                }
            })
            .then(() => {
                this.uploadAvatarLoading = false;
            });
        }

        handleFileUpload() {
            let file: any = this.$refs.file;

            if (file.files[0]) {
                this.file = file.files[0];
                let fileLabelElem: any = document.querySelector('label[for="file"]');
                fileLabelElem.innerText = this.file.name;
            }
        }

        removeErrors() {
            if (this.was422) {
                for (let key of Object.keys(this.errors)) {
                    document.getElementsByName(key)[0].className = '';
                    if (key == 'password') document.getElementsByName('password_confirmation')[0].className = '';
                }
            }

            this.errors = {};
            this.errorType = '';
        }

        setErrors(error: any) {
            if (error.response.status == 422) {
                this.errors = error.response.data.errors;
                this.was422 = true;
                for (let key of Object.keys(this.errors)) {
                    document.getElementsByName(key)[0].className = 'input-error';
                    if (key == 'password') document.getElementsByName('password_confirmation')[0].className = 'input-error';
                }
            }
            else {
                this.errorType = error.response.status + ' ' + error.response.statusText;
            }
            document.getElementsByTagName('h1')[0].scrollIntoView();
        }

        changeInfo() {
            this.changeInfoLoading = true;
            this.removeErrors();

            this.$http({
                url: `auth/change-info`,
                method: 'post',
                data: {
                    name: this.formName,
                    email: this.formEmail,
                },
            })
            .then((response: any) => {
                (this as any).$auth.fetch();
                this.$message.success('Succes!');
            }, (error: any) => {
                this.$message.error('Er is iets misgegaan');
                this.setErrors(error);
            })
            .then(() => {
                this.changeInfoLoading = false;
            });
        }

        changePassword() {
            this.changePasswordLoading = true;
            this.removeErrors();

            this.$http({
                url: `auth/change-password`,
                method: 'post',
                data: {
                    old_password: this.formOldPassword,
                    password: this.formPassword,
                    password_confirmation: this.formPasswordConfirmation,
                },
            })
            .then((response: any) => {
                this.formOldPassword = '';
                this.formPassword = '';
                this.formPasswordConfirmation = '';
                this.$message.success('Succes!');
            }, (error: any) => {
                this.$message.error('Er is iets misgegaan');
                this.setErrors(error);
            })
            .then(() => {
                this.changePasswordLoading = false;
            });
        }
    }
</script>

<style lang="scss">
    .settings .anticon {
        margin-right: 10px;

        svg {
            vertical-align: middle;
        }
    }
</style>

<style lang="scss" scoped>
    .file-area {
        background-color: $light-primary-accent-color;
        display: flex;
        padding: 60px;
        justify-content: center;
        align-items: center;
        margin-bottom: 12px;
        border-radius: $default-border-radius;

        #file {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;

            & + label {
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
            }
        }
    }
    .form-block {
        width: 50%;
    }
    label, input {
        width: 100%;
    }
    label {
        display: block;
    }
</style>
