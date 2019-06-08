<template>
    <div class="find-buddies">
        <div class="box">
            <Message
                v-if="!success"
                message-type="error"
                :messages="errors"
                :extra-str="errorType"
            />
            <form @submit.prevent="findBuddies" action="post">
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
                    placeholder="Van"
                    :disabled="isFromTimePickerDisabled"
                >
                    <button slot="addon" slot-scope="panel" class="btn btn-time-picker" @click="handleClose">Ok</button>
                </a-time-picker>
                <a-time-picker
                    @change="onChangeToTime"
                    :open.sync="isToTimePickerOpen"
                    size="large"
                    format="HH:mm"
                    :allowEmpty="false"
                    inputReadOnly
                    :defaultOpenValue="moment($store.state.selectedFromTime, 'HH:mm').add(2, 'hours').startOf('hour')"
                    :disabledHours="disabledHours"
                    :disabledMinutes="disabledMinutes"
                    :minuteStep="5"
                    placeholder="Tot"
                    :disabled="isToTimePickerDisabled"
                >
                    <button slot="addon" slot-scope="panel" class="btn btn-time-picker" @click="handleClose">Ok</button>
                </a-time-picker>
                <input type="submit" value="Zoek" :class="[{ 'btn-loading': loading }, 'btn']" :disabled="loading">
            </form>
            <div v-if="showBuddies"class="buddies">
                <ul v-if="availableBuddies.length && !loading">
                    <li v-for="buddy in availableBuddies" @click="selectBuddy(buddy)">
                        <div>{{ buddy.name }}</div>
                    </li>
                </ul>
                <ul v-if="loading">
                    <li>Loading...</li>
                </ul>
                <div class="detail">
                    <template v-if="Object.keys(selectedBuddy).length">
                        <h2>{{ selectedBuddy.name }}</h2>
                        <a-divider />
                        <p>{{ selectedBuddy.info }}</p>
                        <div v-for="buddyInfo in JSON.parse(selectedBuddy.available_times)">
                            <p>{{ buddyInfo.day }}</p>
                            <p>{{ buddyInfo.from }}</p>
                            <p>{{ buddyInfo.to }}</p>
                        </div>
                        <button class="btn">Wandelen met deze buddy!</button>
                        <p>Je kan hierna met hem/haar chatten om de locatie af te spreken</p>
                    </template>
                    <template v-else-if="availableBuddies.length && !loading">
                        <div>Klik op namen om meer info te zien</div>
                    </template>
                    <template v-else-if="!loading">
                        <div>
                            <span>Helaas is er niemand beschikbaar op deze dag en tijdstip.</span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class FindBuddies extends Vue {
        name: string = 'FindBuddies';
        moment: any = (this as any).$moment;
        isFromTimePickerDisabled: boolean = true;
        isToTimePickerDisabled: boolean = true;
        isFromTimePickerOpen: boolean = false;
        isToTimePickerOpen: boolean = false;
        errors: any = {};
        errorType: string = '';
        loading: boolean = false;
        showBuddies: boolean = false;
        success: boolean = false;
        availableBuddies: any[] = [];
        selectedBuddy: any = {};
        minutesAfterNowActive: number = 20;

        onChangeDate(date: any, dateString: string) {
            this.isFromTimePickerDisabled = false;
            this.$store.commit('setSelectedDate', dateString);
        }

        onChangeFromTime(time: any, timeString: string) {
            this.isToTimePickerDisabled = false;
            this.$store.commit('setSelectedFromTime', timeString);
        }

        onChangeToTime(time: any, timeString: string) {
            this.$store.commit('setSelectedToTime', timeString);
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
            if (!this.moment().isSame(this.moment(this.$store.state.selectedDate, 'DD/MM/YYYY'), 'day')) {
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
            if (!this.moment().isSame(this.moment(this.$store.state.selectedDate, 'DD/MM/YYYY'), 'day')) {
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
            // else {
            //     for (let i = 0; i < 60; i++) {
            //         minutesToBeDisabled.push(i);
            //     }
            // }

            return minutesToBeDisabled;
        }

        findBuddies() {
            this.loading = true;

            this.$http({
                url: `auth/find-buddies`,
                method: 'post',
                data: {
                    date: this.$store.state.selectedDate,
                    from: this.$store.state.selectedFromTime,
                    to: this.$store.state.selectedToTime,
                }
            })
            .then((response: any) => {
                this.selectedBuddy = {};
                this.showBuddies = true;
                this.success = true;
                this.loading = false;
                this.availableBuddies = response.data.available_buddies_data;

                if (this.availableBuddies.length == 0) {
                    this.$message.info('Niemand gevonden');
                }
                else {
                    this.$message.success('Er zijn wandelbuddies gevonden!');
                }
            }, (error: any) => {
                this.success = false;
                this.loading = false;
                this.$message.error('Niet alle velden zijn juist ingevuld!');

                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
                else {
                    this.errorType = error.response.status + ' ' + error.response.statusText;
                }

                // document.getElementsByClassName('fullscreen-form')[0].scrollIntoView();
            });
        }

        selectBuddy(buddy: any) {
            this.selectedBuddy = buddy;
        }
    }
</script>

<style lang="scss" scoped>
    ul {
        display: inline-block;
        width: 33%;

        li {
            display: block;
            cursor: pointer;
            border: 1px solid black;
            margin: 5px 0;
        }
    }
    .detail {
        display: inline-block;
        vertical-align: top;
        width: 66%;
    }
</style>
