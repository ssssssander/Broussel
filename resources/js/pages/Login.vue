<template>
    <div class="login fullscreen">
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
                <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email" autofocus>
            </div>
            <div class="form-block">
                <label for="password">Wachtwoord</label>
                <input v-model="formPassword" type="password" id="password" name="password" required autocomplete="current-password">
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
                this.$router.replace({ name: 'app-home' });
                console.log(response);
                clear();
            })
            .catch((error: any)=> {
                console.log(error.response);
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
                clear();
            });
        }
    }
</script>

<style lang="scss" scoped>

</style>
