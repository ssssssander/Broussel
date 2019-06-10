<template>
    <div class="register-buddy">
        <div class="fullscreen-form">
            <h1>Word wandelbuddy</h1>
            <Message
                v-if="!success"
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
                    <div v-for="day in Object.keys(timeData.daysOfWeek)" class="time-picker-block">
                        <input type="checkbox" :id="day" v-model="availableTimes[day].available">
                        <label :for="day"><span class="checkbox"></span>{{ timeData.daysOfWeek[day] }}</label>
                        <span class="time-pickers">
                            <a-time-picker
                                v-for="w in Object.keys(timeData.when)"
                                :key="day + '.' + w"
                                @click.native="setCurrentTimePicker(day, w)"
                                @change="onChangeTime"
                                :open="openTimePicker(day, w)"
                                size="large"
                                format="HH:mm"
                                :allowEmpty="false"
                                :defaultOpenValue="$moment().startOf('hour')"
                                inputReadOnly
                                :minuteStep="5"
                                :placeholder="timeData.when[w]"
                                :disabled="isTimePickerDisabled(day, w)"
                                :value="availableTimes[day][w] != '' ? $moment(availableTimes[day][w], 'HH:mm'): null"
                            >
                                <button slot="addon" slot-scope="panel" class="btn btn-time-picker" @click="handleClose()">Ok</button>
                            </a-time-picker>
                            <a v-show="currentTimePicker.lastSelectedDay == day" href="#" class="link" @click.prevent="timeEverywhere(day)">Tijd overal doorvoeren</a>
                        </span>
                    </div>
                </div>
                <div class="form-block">
                    <label for="info">Vertel wat meer over jezelf, waarom wil je wandelbuddy worden?<span class="side-text">Minstens 50 tekens</span></label>
                    <textarea v-model="formInfo" id="info" name="info" required minlength="50" maxlength="65000"></textarea>
                </div>
                <div class="form-block">
                    <input type="submit" value="Inschrijven als wandelbuddy" :class="[{ 'btn-loading': loading }, 'btn']" :disabled="loading">
                </div>
            </form>
            <Message
                v-show="success"
                message-type="success"
                :extra-str="successStr"
            />
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
        errors: any = {};
        errorType: string = '';
        was422: boolean = false;
        loading: boolean = false;
        success: boolean = false;
        successStr: string = 'We hebben jouw inschrijving goed ontvangen, we gaan jouw aanmelding bekijken en spoedig krijg je van ons een e-mail, veel succes en nog een fijne dag!';
        currentTimePicker: any = {
            lastSelectedDay: '',
            day: '',
            when: '',
        };
        availableTimes: any = {
            monday: {
                day: 'monday',
                available: false,
                from: '',
                to: '',
            },
            tuesday: {
                day: 'tuesday',
                available: false,
                from: '',
                to: '',
            },
            wednesday: {
                day: 'wednesday',
                available: false,
                from: '',
                to: '',
            },
            thursday: {
                day: 'thursday',
                available: false,
                from: '',
                to: '',
            },
            friday: {
                day: 'friday',
                available: false,
                from: '',
                to: '',
            },
            saturday: {
                day: 'saturday',
                available: false,
                from: '',
                to: '',
            },
            sunday: {
                day: 'sunday',
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
            this.currentTimePicker.lastSelectedDay = day;
            this.currentTimePicker.day = day;
            this.currentTimePicker.when = when;
        }

        openTimePicker(day: string, when: string) {
            return !this.isTimePickerDisabled(day, when) && this.currentTimePicker.day == day && this.currentTimePicker.when == when;
        }

        onChangeTime(time: any, timeString: string) {
            this.availableTimes[this.currentTimePicker.day][this.currentTimePicker.when] = timeString;
        }

        timeEverywhere(selectedDay: string) {
            for (let day in this.availableTimes) {
                if (this.availableTimes.hasOwnProperty(day)) {
                    this.availableTimes[day].from = this.availableTimes[selectedDay].from;
                    this.availableTimes[day].to = this.availableTimes[selectedDay].to;
                }
            }
        }

        handleClose() {
            this.currentTimePicker.day = '';
            this.currentTimePicker.when = '';
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

            let availableTimesArr: any = Object.values(this.availableTimes);
            let availableTimesOnly = availableTimesArr.filter((availableTime: any) => availableTime.available);

            this.$http({
                url: `auth/register-buddy`,
                method: 'post',
                data: {
                    name: this.formName,
                    email: this.formEmail,
                    info: this.formInfo,
                    available_times: JSON.stringify(availableTimesOnly),
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
                        if (document.getElementsByName(key)[0]) {
                            document.getElementsByName(key)[0].className = 'input-error';
                        }
                    }
                    this.was422 = true;
                }
                else {
                    this.errorType = error.response.status + ' ' + error.response.statusText;
                }

                document.getElementsByTagName('h1')[0].scrollIntoView();
            });
        }
    }
</script>

<style lang="scss" scoped>
    .time-picker-block {
        margin-top: 5px;

        label {
            width: 9em;
        }
    }
    .time-pickers {
        display: inline-flex;
        width: calc(100% - 9.5em);

        .ant-time-picker {
            margin-right: 10px;
        }
        .link {
            font-size: 0.6em;
        }
    }
    @media screen and (max-width: 900px) {
        .time-pickers {
            flex-flow: column wrap;
        }
    }
</style>
