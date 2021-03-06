<template>
    <div class="register-buddy">
        <Message
            v-if="!success"
            message-type="error"
            :messages="errors"
            :extra-str="errorType"
        />
        <form v-show="!success" @submit.prevent="registerBuddy" method="post">
            <div class="form-block">
                <label for="name">{{ 'validation.attributes.name' | trans }}</label>
                <input v-model="formName" type="text" id="name" name="name" required autocomplete="name" maxlength="255" autofocus>
            </div>
            <div class="form-block">
                <label for="email">{{ 'validation.attributes.email' | trans }}</label>
                <input v-model="formEmail" type="email" id="email" name="email" required autocomplete="email" maxlength="255">
            </div>
            <div class="form-block">
                <label>{{ 'vue.languages' | trans }}</label>
                <input type="checkbox" id="nl" v-model="nl">
                <label for="nl"><span class="checkbox"></span>{{ 'vue.nl' | trans }}</label>
                <input type="checkbox" id="fr" v-model="fr">
                <label for="fr"><span class="checkbox"></span>{{ 'vue.fr' | trans }}</label>
                <input type="checkbox" id="en" v-model="en">
                <label for="en"><span class="checkbox"></span>{{ 'vue.en' | trans }}</label>
            </div>
            <div class="form-block">
                <label>{{ 'vue.available_days' | trans }}</label>
                <div v-for="availableTime in availableTimes" class="time-picker-block">
                    <input type="checkbox" :id="availableTime.day" v-model="availableTime.available">
                    <label :for="availableTime.day"><span class="checkbox"></span>{{ 'vue.' + availableTime.day | trans  }}</label>
                    <span class="time-pickers">
                        <a-time-picker
                            v-for="w in when"
                            :key="availableTime.day + '.' + w"
                            @click.native="setCurrentTimePicker(availableTime.day, w)"
                            @change="onChangeTime"
                            :open="openTimePicker(availableTime.day, w)"
                            size="large"
                            format="HH:mm"
                            :allowEmpty="false"
                            :defaultOpenValue="$moment().startOf('hour')"
                            inputReadOnly
                            :minuteStep="5"
                            :placeholder="'validation.attributes.' + w | trans"
                            :disabled="isTimePickerDisabled(availableTime.day, w)"
                            :value="availableTime[w] != '' ? $moment(availableTime[w], 'HH:mm'): null"
                        >
                            <button slot="addon" slot-scope="panel" class="btn btn-time-picker" @click="handleClose()">{{ 'vue.ok' | trans }}</button>
                        </a-time-picker>
                        <a v-show="currentTimePicker.lastSelectedDay == availableTime.day" href="#" class="link" @click.prevent="timeEverywhere(availableTime.day)">{{ 'vue.apply_time_everywhere' | trans }}</a>
                    </span>
                </div>
            </div>
            <div class="form-block">
                <label for="motivation">{{ 'vue.buddy_motivation' | trans }}<span class="side-text">{{ 'vue.at_least_chars' | trans({ chars: 50 }) }}</span></label>
                <textarea v-model="formMotivation" id="motivation" name="motivation" required minlength="50" maxlength="65000"></textarea>
            </div>
            <div class="form-block">
                <LoadingButton :value="'vue.enlist_as_walking_buddy' | trans" :loading="loading" />
            </div>
        </form>
        <Message
            v-show="success"
            message-type="success"
            :extra-str="successStr"
        />
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class RegisterBuddy extends Vue {
        name: string = 'RegisterBuddy';
        lang = (this as any).$lang;
        formName: string = '';
        formEmail: string = '';
        formMotivation: string = '';
        errors: any = {};
        errorType: string = '';
        was422: boolean = false;
        loading: boolean = false;
        success: boolean = false;
        successStr: string = this.lang.get('vue.submission_success');
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
        when = ['from', 'to'];
        nl: boolean = false;
        fr: boolean = false;
        en: boolean = false;

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
                    motivation: this.formMotivation,
                    nl: this.nl,
                    fr: this.fr,
                    en: this.en,
                    available_times: JSON.stringify(availableTimesOnly),
                }
            })
            .then((response: any) => {
                this.$message.success(this.lang.get('vue.submission_received'));
                this.success = true;
            }, (error: any) => {
                this.loading = false;
                this.$message.error(this.lang.get('vue.not_all_fields_correct'));

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
