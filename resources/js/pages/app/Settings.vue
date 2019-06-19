<template>
    <div class="settings">
        <h3>{{ 'vue.set_avatar' | trans }}</h3>
        <Message
            message-type="error"
            :messages="errors"
            :extra-str="errorType"
        />
        <form v-if="$auth.check('buddy')" @submit.prevent="changeInfo" method="post">
            <div class="form-block">
                <label for="name">{{ 'vue.info_about_you' | trans }}<span class="side-text">{{ 'vue.at_least_chars' | trans({ chars: 50 }) }}</span></label>
                <textarea v-model="formInfo" type="text" id="info" name="info" required minlength="50" maxlength="65000"></textarea>
            </div>
            <div class="form-block">
                <LoadingButton :value="'vue.edit' | trans" :loading="changeInfoLoading" />
            </div>
        </form>
        <form enctype="multipart/form-data" @submit.prevent="uploadAvatar" method="post">
            <div class="form-block">
                <div class="file-area">
                    <input type="file" id="file" ref="file" name="file" @change="handleFileUpload">
                    <label for="file" class="btn"><a-icon type="upload" />{{ 'vue.choose_avatar' | trans }}</label>
                </div>
                <LoadingButton :value="'vue.upload' | trans" :loading="uploadAvatarLoading" />
            </div>
        </form>
        <a-divider />
        <h3>{{ 'vue.change_name_email' | trans }}</h3>
        <form @submit.prevent="changeNameEmail" method="post">
            <div class="form-block">
                <label for="name">{{ 'validation.attributes.name' | trans }}</label>
                <input v-model="formName" type="text" id="name" name="name" required autocomplete="name" maxlength="255">
            </div>
            <div class="form-block">
                <label for="email">{{ 'validation.attributes.email' | trans }}</label>
                <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email" maxlength="255">
            </div>
            <div class="form-block">
                <LoadingButton :value="'vue.edit' | trans" :loading="changeNameEmailLoading" />
            </div>
        </form>
        <a-divider />
        <h3>{{ 'vue.change_password' | trans }}</h3>
        <form @submit.prevent="changePassword" method="post">
            <div class="form-block">
                <label for="old_password">{{ 'vue.current_password' | trans }}</label>
                <input v-model="formOldPassword" type="password" id="old_password" name="old_password" required autocomplete="current-password" maxlength="255">
            </div>
            <div class="form-block">
                <label for="password">{{ 'vue.new_password' | trans }}<span class="side-text">{{ 'vue.at_least_chars' | trans({ chars: 8 }) }}</span></label>
                <input v-model="formPassword" type="password" id="password" name="password" required autocomplete="new-password" minlength="8" maxlength="255">
            </div>
            <div class="form-block">
                <label for="password_confirmation">{{ 'vue.retype_new_password' | trans }}</label>
                <input v-model="formPasswordConfirmation" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" minlength="8" maxlength="255">
            </div>
            <div class="form-block">
                <LoadingButton :value="'vue.edit' | trans" :loading="changePasswordLoading" />
            </div>
        </form>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class Settings extends Vue {
        name: string = 'Settings';
        lang = (this as any).$lang;
        file: any = '';
        uploadAvatarLoading: boolean = false;
        changeNameEmailLoading: boolean = false;
        changePasswordLoading: boolean = false;
        changeInfoLoading: boolean = false;
        formInfo: string = '';
        formName: string = '';
        formEmail: string = '';
        formOldPassword: string = '';
        formPassword: string = '';
        formPasswordConfirmation: string = '';
        errors: any = {};
        errorType: string = '';
        was422: boolean = false;

        created() {
            this.formInfo = (this as any).$auth.user().info;
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
                this.$message.success(this.lang.get('vue.avatar_uploaded'));
            }, (error: any) => {
                this.$message.error(this.lang.get('vue.something_went_wrong'));
                this.setErrors(error);
                if (this.errorType) {
                    this.errorType = this.lang.get('vue.avatar_could_not_be_uploaded');
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

        changeNameEmail() {
            this.changeNameEmailLoading = true;
            this.removeErrors();

            this.$http({
                url: `auth/change-name-email`,
                method: 'post',
                data: {
                    name: this.formName,
                    email: this.formEmail,
                },
            })
            .then((response: any) => {
                (this as any).$auth.fetch();
                this.$message.success(this.lang.get('vue.success'));
            }, (error: any) => {
                this.$message.error(this.lang.get('vue.something_went_wrong'));
                this.setErrors(error);
            })
            .then(() => {
                this.changeNameEmailLoading = false;
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
                this.$message.success(this.lang.get('vue.success'));
            }, (error: any) => {
                this.$message.error(this.lang.get('vue.something_went_wrong'));
                this.setErrors(error);
            })
            .then(() => {
                this.changePasswordLoading = false;
            });
        }

        changeInfo() {
            this.changeInfoLoading = true;
            this.removeErrors();

            this.$http({
                url: `auth/change-info`,
                method: 'post',
                data: {
                    info: this.formInfo,
                },
            })
            .then((response: any) => {
                this.$message.success(this.lang.get('vue.success'));
            }, (error: any) => {
                this.$message.error(this.lang.get('vue.something_went_wrong'));
                this.setErrors(error);
            })
            .then(() => {
                this.changeInfoLoading = false;
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
    label, input, textarea {
        width: 100%;
    }
    label {
        display: block;
    }
</style>
