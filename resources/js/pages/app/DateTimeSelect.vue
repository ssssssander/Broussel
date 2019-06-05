<template>
    <div class="datetime-select">
        <div class="box">
            <Message
                message-type="error"
                :messages="errors"
                :extra-str="errorType"
            />
            <form @submit.prevent="validateDateTime" action="post">
                <a-date-picker
                    @change="onChangeDate"
                    :disabledDate="disabledDate"
                    format="DD/MM/YYYY"
                    :showToday="false"
                    :allowClear="false"
                />
                <a-time-picker
                    @change="onChangeFromTime"
                    :open.sync="isFromTimePickerOpen"
                    format="HH:mm"
                    :allowEmpty="false"
                    inputReadOnly
                    :defaultOpenValue="$moment().add(2, 'hours')"
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
                    format="HH:mm"
                    :allowEmpty="false"
                    inputReadOnly
                    :defaultOpenValue="moment($store.state.selectedFromTime, 'HH:mm').add(2, 'hours')"
                    :disabledHours="disabledHours"
                    :disabledMinutes="disabledMinutes"
                    :minuteStep="5"
                    placeholder="Tot"
                    :disabled="isToTimePickerDisabled"
                >
                    <button slot="addon" slot-scope="panel" class="btn btn-time-picker" @click="handleClose">Ok</button>
                </a-time-picker>
                <input type="submit" value=">Ga verder" :class="[{ 'btn-loading': loading }, 'btn']" :disabled="loading">
            </form>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class DateTimeSelect extends Vue {
        name: string = 'DateTimeSelect';
        moment: any = (this as any).$moment;
        isFromTimePickerDisabled: boolean = true;
        isToTimePickerDisabled: boolean = true;
        isFromTimePickerOpen: boolean = false;
        isToTimePickerOpen: boolean = false;
        errors: object = {};
        errorType: string = '';
        loading: boolean = false;

        onChangeDate(date: any, dateString: string) {
            this.isFromTimePickerDisabled = false;
            this.$store.commit('setSelectedDate', dateString);
            console.log(date);
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
            if (this.moment(this.$store.state.selectedDate, 'DD/MM/YYY').day() != this.moment().day()) {
                return [];
            }

            let hoursToBeDisabled: number[] = [];
            let currentMinute: number = this.moment().minute();
            let currentHour: number = this.moment().hour();
            let minuteDiff = 60 - currentMinute;

            for (let i = 0; i < currentHour + ((minuteDiff < 20 && currentHour != 23) ? 1 : 0); i++) {
                hoursToBeDisabled.push(i);
            }

            return hoursToBeDisabled;
        }

        disabledMinutes(selectedHour: any) {
            if (this.moment(this.$store.state.selectedDate, 'DD/MM/YYYY').day() != this.moment().day()) {
                return [];
            }

            let minutesToBeDisabled: number[] = [];
            let currentMinute: number = this.moment().minute();
            let currentHour: number = this.moment().hour();
            let minuteDiff = 60 - currentMinute;

            if (selectedHour - 1 == currentHour && minuteDiff < 20) {
                for (let i = 0; i < (20 - minuteDiff); i++) {
                    minutesToBeDisabled.push(i);
                }
            }
            if (selectedHour == currentHour) {
                for (let i = 0; i < currentMinute + 20; i++) {
                    minutesToBeDisabled.push(i);
                }
            }

            return minutesToBeDisabled;
        }

        validateDateTime() {
            this.loading = true;

            this.$http({
                url: `auth/validate-datetime`,
                method: 'post',
                data: {
                    date: this.$store.state.selectedDate,
                    from: this.$store.state.selectedFromTime,
                    to: this.$store.state.selectedToTime,
                }
            })
                .then((response: any) => {
                    this.$router.push({ name: 'choose-buddy' });
                }, (error: any) => {
                    console.log(error.response);
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
    }
</script>

<style lang="scss" scoped>

</style>
