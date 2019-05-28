<template>
    <div class="login">
        <form @submit.prevent="login" class="fullscreen-form" method="post">
            <div v-show="Object.keys(errors).length" class="errors">
                <ul>
                    <li v-for="errorArr in errors">
                        <span v-for="error in errorArr">
                            {{ error }}
                        </span>
                    </li>
                </ul>
            </div>
            <div class="form-block">
                <label for="email">E-mailadres</label>
                <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email" maxlength="255" autofocus>
            </div>
            <div class="form-block">
                <label for="password">Wachtwoord</label>
                <input v-model="formPassword" type="password" id="password" name="password" required autocomplete="current-password" maxlength="255">
            </div>
            <div class="form-block">
                <input type="submit" value="Inloggen" class="btn" id="login-btn">
            </div>
        </form>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Login extends Vue {
        name: string = 'Login';
        formEmail: string = '';
        formPassword: string = '';
        errors: object = {};

        mounted() {
            document.getElementById('email').focus();
        }

        login() {
            function clear() {
                window.clearInterval(loadingInterval);
                document.getElementById('login-btn').setAttribute('value', 'Inloggen');
            }

            for (let key of Object.keys(this.errors)) {
                document.getElementsByName(key)[0].className = '';
            }

            let i = 0;
            let loadingInterval = window.setInterval(() => {
                document.getElementById('login-btn').setAttribute('value', 'We zijn er mee bezig' + '.'.repeat(i++));
                if (i > 3) i = 0;
            }, 200);

            this.axios.post('/login', {
                email: this.formEmail,
                password: this.formPassword,
            })
            .then((response: any) => {
                clear();
                this.$router.replace({ name: 'dashboard' });
                this.$message.success('Je bent met succes ingelogd!');
            })
            .catch((error: any)=> {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                    for (let key of Object.keys(this.errors)) {
                        document.getElementsByName(key)[0].className = 'input-error';
                    }
                }
                clear();
            });
        }
    }
</script>

<style lang="scss" scoped>

</style>
