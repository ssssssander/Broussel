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
                    <div v-for="day in Object.keys(timeData.daysOfWeek)" class="time-picker-block" :name="day">
                        <input type="checkbox" :id="day" v-model="availableTimes[day].available">
                        <label :for="day"><span class="checkbox"></span>{{ timeData.daysOfWeek[day] }}</label>
                        <span class="time-pickers">
                            <a-time-picker
                                v-for="w in Object.keys(timeData.when)"
                                :key="day + '.' + w"
                                :name="day + '.' + w"
                                @click.native="setCurrentTimePicker(day, w)"
                                @change="onChangeTime"
                                :open="openTimePicker(day, w)"
                                format="HH:mm"
                                :allowEmpty="false"
                                :minuteStep="5"
                                :placeholder="timeData.when[w]"
                                :disabled="isTimePickerDisabled(day, w)"
                            >
                                <button slot="addon" slot-scope="panel" class="btn btn-time-picker" @click="handleClose()">Ok</button>
                            </a-time-picker>
                        </span>
                    </div>
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
        currentTimePicker: any = {
            day: '',
            when: '',
        };
        availableTimes: any = {
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
            wednesday: {
                available: false,
                from: '',
                to: '',
            },
            thursday: {
                available: false,
                from: '',
                to: '',
            },
            friday: {
                available: false,
                from: '',
                to: '',
            },
            saturday: {
                available: false,
                from: '',
                to: '',
            },
            sunday: {
                available: false,
                from: '',
                to: '',
            },
        };
        timeData: any = {
            daysOfWeek: {
                'monday': 'Maandag',
                'tuesday': 'Dinsdag',
                'wednesday': 'Woensdag',
                'thursday': 'Donderdag',
                'friday': 'Vrijdag',
                'saturday': 'Zaterdag',
                'sunday': 'Zondag',
            },
            when: {
                'from': 'Van',
                'to': 'Tot',
            }
        };

        // minlength="50"

        mounted() {
            document.getElementById('name').focus();
        }

        isTimePickerDisabled(day: string, when: string) {
            if (when == 'from') {
                return !this.availableTimes[day].available;
            }
            if (when == 'to') {
                return !this.availableTimes[day].available || this.availableTimes[day].from == '';
            }
        }

        setCurrentTimePicker(day: string, when: string) {
            this.currentTimePicker.day = day;
            this.currentTimePicker.when = when;
        }

        openTimePicker(day: string, when: string) {
            return !this.isTimePickerDisabled(day, when) && this.currentTimePicker.day == day && this.currentTimePicker.when == when;
        }

        onChangeTime(time: any, timeString: string) {
            this.availableTimes[this.currentTimePicker.day][this.currentTimePicker.when] = timeString;
        }

        handleClose() {
            this.currentTimePicker.day = '';
            this.currentTimePicker.when = '';
            console.log(this.availableTimes);
        }

        registerBuddy() {
            if (this.loading) {
                return;
            }

            if (this.was422) {
                for (let key of Object.keys(this.errors)) {
                    if (document.getElementsByName(key)[0]) {
                        document.getElementsByName(key)[0].className = '';
                    }
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
                console.log(error.response);
                this.loading = false;
                this.$message.error('Niet alle velden zijn juist ingevuld!');

                if (error.response.status == 422) {
                    console.log(error.response);
                    this.errors = error.response.data.errors;
                    for (let key of Object.keys(this.errors)) {
                        if (document.getElementsByName(key)[0]) {
                            document.getElementsByName(key)[0].className = 'input-error';
                        }
                    }
                    this.was422 = true;
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
    .time-picker-block label {
        width: 9em;
    }
    .time-pickers .ant-time-picker {
        margin-right: 10px;
    }
</style>
