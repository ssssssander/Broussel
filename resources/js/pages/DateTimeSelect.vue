<template>
    <div class="datetime-select">
        <div class="box">
            <a-date-picker @change="onChangeDate" />
            <a-time-picker format="HH:mm" @change="onChangeTime" />
            <button class="btn" @click="next">Kies</button>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class DateTimeSelect extends Vue {
        name: string = 'DateTimeSelect';

        onChangeDate(date: any, dateString: any) {
            console.log(date, dateString);
        }

        onChangeTime(time: any, timeString: any) {
            console.log(time, timeString);
        }

        next() {
            this.$router.push({ name: 'choose-buddy' });
        }
    }
</script>

<style lang="scss" scoped>
    
</style>
