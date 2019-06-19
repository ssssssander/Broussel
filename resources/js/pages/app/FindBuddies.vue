<template>
    <div class="find-buddies">
        <Message
            message-type="error"
            :messages="errors"
            :extra-str="errorType"
        />
        <form @submit.prevent="findBuddies" method="post">
            <a-date-picker
                @change="onChangeDate"
                size="large"
                :disabledDate="disabledDate"
                format="DD/MM/YYYY"
                :showToday="false"
                :allowClear="false"
            />
            <a-time-picker
                @change="onChangeFromTime"
                :open.sync="isFromTimePickerOpen"
                size="large"
                format="HH:mm"
                :allowEmpty="false"
                inputReadOnly
                :defaultOpenValue="$moment().add(2, 'hours').startOf('hour')"
                :disabledHours="disabledHours"
                :disabledMinutes="disabledMinutes"
                :minuteStep="5"
                :placeholder="'validation.attributes.from' | trans"
                :disabled="isFromTimePickerDisabled"
            >
                <button slot="addon" slot-scope="panel" class="btn btn-time-picker" @click="handleClose">{{ 'vue.ok' | trans }}</button>
            </a-time-picker>
            <a-time-picker
                @change="onChangeToTime"
                :open.sync="isToTimePickerOpen"
                size="large"
                format="HH:mm"
                :allowEmpty="false"
                inputReadOnly
                :defaultOpenValue="moment(selectedFromTime, 'HH:mm').add(2, 'hours').startOf('hour')"
                :disabledHours="disabledHours"
                :disabledMinutes="disabledMinutes"
                :minuteStep="5"
                :placeholder="'validation.attributes.to' | trans"
                :disabled="isToTimePickerDisabled"
            >
                <button slot="addon" slot-scope="panel" class="btn btn-time-picker" @click="handleClose">{{ 'vue.ok' | trans }}</button>
            </a-time-picker>
            <LoadingButton :value="'vue.search_for_walking_buddies' | trans" :loading="loading" />
        </form>
        <div v-if="showResults && !firstPress" class="buddies">
            <div class="side">
                <input type="search" v-model="search" :placeholder="'vue.search_by_name' | trans">
                <ul>
                    <a-skeleton active avatar :title="false" :paragraph="{ rows: 3, width: [250, 250] }" :loading="loading">
                        <div>
                            <li v-for="buddy in filteredBuddies" @click="selectBuddy(buddy)" :class="{ active: buddy == selectedBuddy }">
                                <div>
                                    <img class="avatar avatar-small" :src="buddy.avatar_path" :alt="buddy.name">
                                    <span class="name">{{ buddy.name }}</span>
                                    <span class="icon"><a-icon type="right" /></span>
                                </div>
                            </li>
                        </div>
                    </a-skeleton>
                    <li v-if="!filteredBuddies.length && !loading"><i>{{ 'vue.nobody_found' | trans }}</i></li>
                </ul>
            </div>
            <BuddyDetail
                v-if="Object.keys(selectedBuddy).length"
                :key="buddyDetailKey"
                payment
                :selected-buddy="selectedBuddy"
                :final-date="finalDate"
                :final-from-time="finalFromTime"
                :final-to-time="finalToTime"
            />
            <i class="text-center hint" v-else>{{ 'vue.click_names' | trans }}</i>
        </div>
        <i class="text-center no-results" v-if="!showResults && !firstPress">{{ 'vue.nobody_available' | trans }}</i>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class FindBuddies extends Vue {
        name: string = 'FindBuddies';
        lang = (this as any).$lang;
        moment: any = (this as any).$moment;
        isFromTimePickerDisabled: boolean = true;
        isToTimePickerDisabled: boolean = true;
        isFromTimePickerOpen: boolean = false;
        isToTimePickerOpen: boolean = false;
        errors: any = {};
        errorType: string = '';
        loading: boolean = false;
        showResults: boolean = true;
        firstPress: boolean = true;
        availableBuddies: any[] = [];
        selectedBuddy: any = {};
        minutesAfterNowActive: number = 20;
        search: string = '';
        selectedDate: string = '';
        selectedFromTime: string = '';
        selectedToTime: string = '';
        finalDate: string = '';
        finalFromTime: string = '';
        finalToTime: string = '';
        buddyDetailKey: number = 0;

        get filteredBuddies() {
            return this.availableBuddies.filter(availableBuddy => {
                let normalized = availableBuddy.name.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
                return normalized.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
            });
        }

        onChangeDate(date: any, dateString: string) {
            this.isFromTimePickerDisabled = false;
            this.selectedDate = dateString;
        }

        onChangeFromTime(time: any, timeString: string) {
            this.isToTimePickerDisabled = false;
            this.selectedFromTime = timeString;
        }

        onChangeToTime(time: any, timeString: string) {
            this.selectedToTime = timeString;
        }

        handleClose(){
            this.isFromTimePickerOpen = false;
            this.isToTimePickerOpen = false;
        }

        disabledDate(current: any) {
            // Enabled between today and 1 year from today
            return current < this.moment().subtract(1, 'days').endOf('day') || current > this.moment().add(1, 'years').endOf('day');
        }

        disabledHours() {
            if (!this.moment().isSame(this.moment(this.selectedDate, 'DD/MM/YYYY'), 'day')) {
                return [];
            }

            let hoursToBeDisabled: number[] = [];
            let currentMinute: number = this.moment().minute();
            let currentHour: number = this.moment().hour();
            let minuteDiff = 60 - currentMinute;

            for (let i = 0; i < currentHour + ((minuteDiff < this.minutesAfterNowActive && currentHour != 23) ? 1 : 0); i++) {
                hoursToBeDisabled.push(i);
            }

            return hoursToBeDisabled;
        }

        disabledMinutes(selectedHour: any) {
            if (!this.moment().isSame(this.moment(this.selectedDate, 'DD/MM/YYYY'), 'day')) {
                return [];
            }

            let minutesToBeDisabled: number[] = [];
            let currentMinute: number = this.moment().minute();
            let currentHour: number = this.moment().hour();
            let minuteDiff = 60 - currentMinute;

            if (selectedHour - 1 == currentHour && minuteDiff < this.minutesAfterNowActive) {
                for (let i = 0; i < (this.minutesAfterNowActive - minuteDiff); i++) {
                    minutesToBeDisabled.push(i);
                }
            }
            else if (selectedHour == currentHour) {
                for (let i = 0; i < currentMinute + this.minutesAfterNowActive; i++) {
                    minutesToBeDisabled.push(i);
                }
            }

            return minutesToBeDisabled;
        }

        findBuddies() {
            this.firstPress = false;
            this.search = '';
            this.loading = true;
            this.selectedBuddy = {};

            this.$http({
                url: `auth/find-buddies`,
                method: 'post',
                data: {
                    date: this.selectedDate,
                    from: this.selectedFromTime,
                    to: this.selectedToTime,
                }
            })
            .then((response: any) => {
                this.showResults = true;
                this.errors = {};
                this.errorType = '';
                this.availableBuddies = response.data.available_buddies_data;
                this.finalDate = this.selectedDate;
                this.finalFromTime = this.selectedFromTime;
                this.finalToTime = this.selectedToTime;

                if (this.availableBuddies.length == 0) {
                    this.$message.info(this.lang.get('vue.nobody_found'));
                    this.showResults = false;
                }
                else {
                    this.$message.success(this.lang.get('vue.found_walking_buddies'));
                }
            }, (error: any) => {
                this.showResults = false;
                this.$message.error(this.lang.get('vue.not_all_fields_correct'));

                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
                else {
                    this.errorType = error.response.status + ' ' + error.response.statusText;
                }

                document.getElementsByTagName('h1')[0].scrollIntoView();
            })
            .then(() => {
                this.loading = false;
            });
        }

        selectBuddy(buddy: any) {
            this.selectedBuddy = buddy;
            this.buddyDetailKey += 1;
        }
    }
</script>

<style lang="scss">
    .find-buddies .ant-calendar-picker, .find-buddies .ant-time-picker {
        display: block;
        width: 50%;
        margin-top: 15px;
    }
</style>

<style lang="scss" scoped>
    .no-results {
        display: block;
    }
    form {
        margin-bottom: 30px;

        .btn {
            width: 50%;
            margin-top: 15px;
        }
    }
    .buddies {
        padding: 15px;
        border: $light-border;

        .hint {
            width: 66%;
            display: inline-block;
            vertical-align: top;
        }
        .side {
            display: inline-block;
            width: 33%;

            input[type="search"] {
                width: 100%;
            }
            ul {
                margin-top: 20px;

                li {
                    display: block;
                    cursor: pointer;
                    padding: 20px 10px;
                    border-bottom: $light-border;

                    &:hover, &.active {
                        color: $dark-primary-accent-color;
                    }
                    img, .name, .icon {
                        vertical-align: middle;
                    }
                    .name {
                        margin-left: 5px;
                    }
                    .icon {
                        float: right;
                    }
                }
            }
        }
    }
    @media screen and (max-width: 900px) {
        .find-buddies .ant-calendar-picker, .find-buddies .ant-time-picker, form .btn {
            width: 100%;
        }
    }
</style>
