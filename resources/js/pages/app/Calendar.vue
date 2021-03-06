<template>
    <div class="calendar">
        <i v-if="!success">{{ 'vue.loading' | trans }}</i>
        <div v-if="success">
            <div>
                <a href="#" class="link" @click.prevent="makeIcal">{{ 'vue.export_calendar' | trans }}</a>
                <input v-if="isExported" type="text" readonly v-model="iCalUrl">
                <button v-if="isExported" type="button" class="btn" @click="copyICalUrl">{{ 'vue.copy' | trans }}</button>
                <p v-if="isExported">{{ 'vue.copy_this_url' | trans }}</p>
            </div>
            <a-calendar>
                <ul class="events" slot="dateCellRender" slot-scope="value">
                    <li v-for="appointment in getAppointmentsByValue(value)"
                        :key="appointment.id"
                        @click="goToProfile(appointment.person_role, appointment.person_id)"
                        class="appointment"
                    >
                        <span><span class="dot"></span>{{ 'vue.from_until_with' | trans({ from: moment(appointment.time_from, 'HH:mm').format('HH:mm'), to: moment(appointment.time_to, 'HH:mm').format('HH:mm'), name: appointment.person_name }) }}</span>
                    </li>
                </ul>
                <template slot="monthCellRender" slot-scope="value">
                    <div v-if="getAppointmentsPerMonth(value)" class="month">
                        <span>{{ 'vue.walks_this_month' | trans({ appointments: getAppointmentsPerMonth(value) }) }}</span>
                    </div>
                </template>
            </a-calendar>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class Calendar extends Vue {
        name: string = 'Calendar';
        lang = (this as any).$lang;
        appointments: any[] = [];
        moment: any = (this as any).$moment;
        success: boolean = false;
        iCalUrl: string = '';
        isExported: boolean = false;

        copyICalUrl() {
            if (!this.isExported) {
                return;
            }

            (this as any).$copyText(this.iCalUrl).then((e: any) => {
                this.$message.success(this.lang.get('vue.copied'));
            }, (e: any) => {
                this.$message.error(this.lang.get('vue.something_went_wrong'));
            });
        }

        created() {
            this.getAppointments();
        }

        getAppointments() {
            this.$http({
                url: `auth/get-appointments`,
                method: 'get',
            })
            .then((response: any) => {
                this.appointments = response.data.appointments_data;
                this.success = true;
            }, (error: any) => {
                this.$message.error(this.lang.get('vue.something_went_wrong'));
            });
        }

        getAppointmentsByValue(value: any) {
            let filteredAppointments = [];

            for (let appointment of this.appointments) {
                if (appointment.day == value.format('YYYY-MM-DD')) {
                    filteredAppointments.push(appointment);
                }
            }

            return filteredAppointments;
        }

        getAppointmentsPerMonth(value: any) {
            let filteredAppointments = [];

            for (let appointment of this.appointments) {
                if (this.moment(appointment.day).format('YYYY-MM') == value.format('YYYY-MM')) {
                    filteredAppointments.push(appointment);
                }
            }

            return filteredAppointments.length;
        }

        goToProfile(role: string, id: string) {
            if (role == 'buddy') {
                this.$router.push({ name: 'buddy-profile', params: { id: id } });
            }
        }

        makeIcal() {
            if (this.isExported) {
                return;
            }

            this.$http({
                url: `auth/make-ical`,
                method: 'get',
            })
            .then((response: any) => {
                this.iCalUrl = response.data.ical_url;
                this.isExported = true;
            }, (error: any) => {
                this.$message.error(this.lang.get('vue.something_went_wrong'));
            });
        }
    }
</script>

<style lang="scss" scoped>
    .appointment {
        font-weight: bold;
        margin-top: 5px;
        transition: background-color 0.3s;
        border-radius: $default-border-radius;

        &:hover {
            background-color: $primary-accent-color;
            transition: background-color 0.3s;
        }
    }
    .month {
        font-size: 1.6em;
    }
    .dot {
        width: 6px;
        height: 6px;
        display: inline-block;
        border-radius: 50%;
        vertical-align: middle;
        position: relative;
        top: -1px;
        background-color: $primary-accent-color;
        margin-right: 8px;
    }
</style>
