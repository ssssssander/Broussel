<template>
    <div class="datetime-select">
        <div class="box">
            <a-date-picker
                @change="onChangeDate"
                :disabledDate="disabledDate"
                format="DD/MM/YYYY"
                :showToday="false"
                :allowClear="false"
                id="abc"
            />
            <a-time-picker
                @change="onChangeFromTime"
                :open.sync="isFromTimePickerOpen"
                format="HH:mm"
                :allowEmpty="false"
                :defaultOpenValue="$moment().add(2, 'hours')"
                :disabledHours="disabledHours"
                :disabledMinutes="disabledMinutes"
                :minuteStep="5"
                :disabled="isFromTimePickerDisabled"
            >
                <button slot="addon" slot-scope="panel" class="btn btn-time-picker" @click="handleClose">Ok</button>
            </a-time-picker>
            <a-time-picker
                @change="onChangeToTime"
                :open.sync="isToTimePickerOpen"
                format="HH:mm"
                :allowEmpty="false"
                :defaultOpenValue="moment($store.state.selectedFromTime).add(2, 'hours')"
                :disabledHours="disabledHours"
                :disabledMinutes="disabledMinutes"
                :minuteStep="5"
                :disabled="isToTimePickerDisabled"
            >
                <button slot="addon" slot-scope="panel" class="btn btn-time-picker" @click="handleClose">Ok</button>
            </a-time-picker>
            <button class="btn" @click="next">Kies</button>
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

        onChangeDate(date: any, dateString: string) {
            this.isFromTimePickerDisabled = false;
            this.$store.commit('setSelectedDate', date);
        }

        onChangeFromTime(time: any, timeString: string) {
            this.isToTimePickerDisabled = false;
            this.$store.commit('setSelectedFromTime', time);
        }

        onChangeToTime(time: any, timeString: string) {
            this.$store.commit('setSelectedToTime', time);
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
            if (this.$store.state.selectedDate.day() != this.moment().day()) {
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
            if (this.$store.state.selectedDate.day() != this.moment().day()) {
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

        next() {
            this.$router.push({ name: 'choose-buddy' });
        }
    }
</script>

<style lang="scss" scoped>

</style>
