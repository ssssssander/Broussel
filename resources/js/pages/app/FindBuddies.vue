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
            <div v-if="success" class="buddies">
                <div class="side">
                    <input type="search" v-model="search" placeholder="Zoeken op naam">
                    <a-skeleton active :title="false" :paragraph="{ rows: 5, width: [250, 250] }" :loading="loading">
                        <ul>
                            <li v-for="buddy in filteredBuddies" @click="selectBuddy(buddy)">
                                {{ buddy.name }}
                            </li>
                        </ul>
                    </a-skeleton>
                </div>
                <div class="detail">
                    <div v-if="Object.keys(selectedBuddy).length">
                        <h2>{{ selectedBuddy.name }}</h2>
                        <a-divider />
                        <p>{{ selectedBuddy.info }}</p>
                        <div v-for="buddyInfo in JSON.parse(selectedBuddy.available_times)">
                            <p>{{ buddyInfo.day }}</p>
                            <p>{{ buddyInfo.from }}</p>
                            <p>{{ buddyInfo.to }}</p>
                        </div>
                        <button class="btn">Wandelen met deze buddy! (€ {{ selectedBuddy.price }})</button>
                        <p>Op {{ finalDate }} van {{ finalFromTime }} tot {{ finalToTime }}.</p>
                        <p>Je kan hierna met hem/haar chatten om de locatie af te spreken</p>
                    </div>
                    <div v-else>Klik op namen om meer info te zien</div>
                </div>
            </div>
            <div v-if="!success & !firstTime">Helaas is er niemand beschikbaar op deze dag en tijdstip.</div>
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
        success: boolean = false;
        availableBuddies: any[] = [];
        selectedBuddy: any = {};
        minutesAfterNowActive: number = 20;
        firstTime: boolean = true;
        search: string = '';
        finalDate: string = '';
        finalFromTime: string = '';
        finalToTime: string = '';

        get filteredBuddies() {
            return this.availableBuddies.filter(availableBuddy => {
                return availableBuddy.name.toLowerCase().includes(this.search.toLowerCase());
            });
        }

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
            this.selectedBuddy = {};

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
                this.success = true;
                this.loading = false;
                this.firstTime = false;
                this.availableBuddies = response.data.available_buddies_data;
                this.finalDate = this.$store.state.selectedDate;
                this.finalFromTime = this.$store.state.selectedFromTime;
                this.finalToTime = this.$store.state.selectedToTime;

                if (this.availableBuddies.length == 0) {
                    this.$message.info('Niemand gevonden');
                    this.success = false;
                }
                else {
                    this.$message.success('Er zijn wandelbuddies gevonden!');
                }
            }, (error: any) => {
                this.success = false;
                this.loading = false;
                this.firstTime = false;
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
    .side {
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
