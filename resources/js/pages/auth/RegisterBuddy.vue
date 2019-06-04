<template>
    <div class="register-buddy">
        <div class="fullscreen-form">
            <h1>Word wandelbuddy</h1>
            <Message
                message-type="error"
                :messages="errors"
                :extra-str="errorType"
            />
            <form v-show="!success" @submit.prevent="registerBuddy" method="post">
                <div class="form-block">
                    <label for="name">Naam</label>
                    <input v-model="formName" type="text" id="name" name="name" required autocomplete="name" maxlength="255" autofocus>
                </div>
                <div class="form-block">
                    <label for="email">E-mailadres</label>
                    <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email" maxlength="255">
                </div>
                <div class="form-block">
                    <label>Beschikbare dagen</label>
                    <input type="checkbox" id="monday" v-model="availableTimes.monday.available">
                    <label for="monday"><span></span>Maandag</label>
                    <a-time-picker
                        @change="onChangeTime"
                        format="HH:mm"
                        :allowEmpty="false"
                        :minuteStep="5"
                        :disabled="!availableTimes.monday.available"
                    />
                    <a-time-picker
                        @change="onChangeTime"
                        format="HH:mm"
                        :allowEmpty="false"
                        :minuteStep="5"
                        :disabled="!availableTimes.monday.available || availableTimes.monday.from"
                    />
                    <input type="checkbox" id="tuesday" v-model="availableTimes.tuesday.available">
                    <label for="tuesday"><span></span>Dinsdag</label>
                    <a-time-picker
                        @change="onChangeTime"
                        format="HH:mm"
                        :allowEmpty="false"
                        :minuteStep="5"
                        :disabled="!availableTimes.tuesday.available"
                    />
                    <a-time-picker
                        @change="onChangeTime"
                        format="HH:mm"
                        :allowEmpty="false"
                        :minuteStep="5"
                        :disabled="!availableTimes.tuesday.available || availableTimes.tuesday.from"
                    />
                    <input type="checkbox" id="wednesday" v-model="availableTimes.wednesday">
                    <label for="wednesday"><span></span>Woensdag</label>
                    <input type="checkbox" id="thursday" v-model="availableTimes.thursday">
                    <label for="thursday"><span></span>Donderdag</label>
                    <input type="checkbox" id="friday" v-model="availableTimes.friday">
                    <label for="friday"><span></span>Vrijdag</label>
                    <input type="checkbox" id="saturday" v-model="availableTimes.saturday">
                    <label for="saturday"><span></span>Zaterdag</label>
                    <input type="checkbox" id="sunday" v-model="availableTimes.sunday">
                    <label for="sunday"><span></span>Zondag</label>
                </div>
                <div class="form-block">
                    <label for="info">Vertel wat meer over jezelf, waarom wil je wandelbuddy worden?<span class="side-text">Minstens 50 tekens</span></label>
                    <textarea v-model="formInfo" id="info" name="info" required maxlength="65000"></textarea>
                </div>
                <div class="form-block">
                    <input type="submit" value="Inschrijven als wandelbuddy" :class="[{ 'btn-loading': loading }, 'btn']" id="register-btn" :disabled="loading">
                </div>
                <div class="form-block text-center">
                    <router-link :to="{ name: 'login' }" class="link">Ben je al een wandelbuddy? Log hier in.</router-link>
                </div>
            </form>
            <div v-show="success">
                <Message
                    message-type="success"
                    :extra-str="successStr"
                />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class RegisterBuddy extends Vue {
        name: string = 'RegisterBuddy';
        formName: string = '';
        formEmail: string = '';
        formInfo: string = '';
        errors: object = {};
        errorType: string = '';
        was422: boolean = false;
        loading: boolean = false;
        success: boolean = false;
        successStr: string = 'We hebben jouw inschrijving goed ontvangen, we gaan jouw aanmelding bekijken en spoedig krijg je van ons een e-mail, veel succes en nog een fijne dag!';
        availableTimes: object = {
            monday: {
                available: false,
                from: '',
                to: '',
            },
            tuesday: {
                available: false,
                from: '',
                to: '',
            },
            wednesday: false,
            thursday: false,
            friday: false,
            saturday: false,
            sunday: false,
        };

        mounted() {
            document.getElementById('name').focus();
        }

        onChangeTime(time: any, timeString: string) {
            console.log(time);
            console.log(timeString);
        }

        registerBuddy() {
            if (this.loading) {
                return;
            }

            if (this.was422) {
                for (let key of Object.keys(this.errors)) {
                    document.getElementsByName(key)[0].className = '';
                }
            }

            this.loading = true;

            this.$http({
                url: `auth/register-buddy`,
                method: 'post',
                data: {
                    name: this.formName,
                    email: this.formEmail,
                    info: this.formInfo,
                    available_times: JSON.stringify(this.availableTimes),
                }
            })
            .then((response: any) => {
                this.$message.success('Je inschrijving is goed ontvangen!');
                this.success = true;
            }, (error: any) => {
                this.loading = false;
                this.$message.error('Niet alle velden zijn juist ingevuld!');

                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                    for (let key of Object.keys(this.errors)) {
                        document.getElementsByName(key)[0].className = 'input-error';
                        this.was422 = true;
                    }
                }
                else {
                    this.errorType = error.response.status + ' ' + error.response.statusText;
                }

                document.getElementsByClassName('fullscreen-form')[0].scrollIntoView();
            });
        }
    }
</script>

<style lang="scss" scoped>

</style>
