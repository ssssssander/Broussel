<template>
    <div class="calendar">
        <i v-if="!success">Kalender laden...</i>
        <a-calendar v-if="success">
            <ul class="events" slot="dateCellRender" slot-scope="value">
                <li v-for="appointment in getAppointmentsByValue(value)"
                    :key="appointment.id"
                    @click="goToProfile(appointment.person_role, appointment.person_id)"
                    class="appointment"
                >
                    <span><span class="dot"></span>Van {{ moment(appointment.time_from, 'HH:mm').format('HH:mm') }} tot {{ moment(appointment.time_to, 'HH:mm').format('HH:mm') }} met {{ appointment.person_name }}</span>
                </li>
            </ul>
            <template slot="monthCellRender" slot-scope="value">
                <div v-if="getAppointmentsPerMonth(value)" class="month">
                    <span>{{ getAppointmentsPerMonth(value) }} wandelingen deze maand</span>
                </div>
            </template>
        </a-calendar>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class Calendar extends Vue {
        name: string = 'Calendar';
        appointments: any[] = [];
        moment: any = (this as any).$moment;
        success: boolean = false;

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
                this.$message.error('Er is iets misgegaan bij het ophalen van de gegevens');
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

        goToProfile(role: number, id: string) {
            if (role == 2) {
                this.$router.push({ name: 'buddy-profile', params: { id: id } })
            }
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
