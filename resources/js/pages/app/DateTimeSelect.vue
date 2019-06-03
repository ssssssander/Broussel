<template>
    <div class="datetime-select">
        <div class="box">
            <a-date-picker
                @change="onChangeDate"
                :disabledDate="disabledDate"
                format="DD/MM/YYYY"
                :showToday="false"
                :allowClear="false"
            />
            <a-time-picker
                @change="onChangeTime"
                format="HH:mm"
                :allowEmpty="false"
                :defaultOpenValue="$moment().add(2, 'hours')"
                :disabledHours="disabledHours"
                :disabledMinutes="disabledMinutes"
            />
            <button class="btn" @click="next">Kies</button>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class DateTimeSelect extends Vue {
        name: string = 'DateTimeSelect';
        moment = (this as any).$moment;
        selectedDate: any;

        onChangeDate(date: any, dateString: any) {
            console.log(date, dateString);
            this.selectedDate = date;
        }

        onChangeTime(time: any, timeString: any) {
            console.log(time, timeString);
        }

        disabledDate(current: any) {
            // Enabled between today and 1 year from today
            return current < this.moment().subtract(1, 'days').endOf('day') || current > this.moment().add(1, 'years').endOf('day');
        }

        disabledHours() {
            let hoursToBeDisabled: number[] = [];
            let currentHour: any = this.moment().hour();
            for (let i = 0; i < currentHour; i++) {
                hoursToBeDisabled.push(i);
            }
            return hoursToBeDisabled;
        }

        disabledMinutes() {

        }

        next() {
            this.$router.push({ name: 'choose-buddy' });
        }
    }
</script>

<style lang="scss" scoped>
    
</style>
