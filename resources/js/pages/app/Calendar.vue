<template>
    <div class="calendar">
        <a-calendar>
            <ul class="events" slot="dateCellRender" slot-scope="value">
                <li v-for="appointment in getAppointmentsByValue(value)"
                    :key="appointment.id"
                    @click="goToProfile(appointment.person_role, appointment.person_id)"
                    class="appointment"
                >
                    <span><span class="dot"></span>Van {{ appointment.time_from }} tot {{ appointment.time_to }}: {{ appointment.person_name }}</span>
                </li>
            </ul>
        </a-calendar>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class Calendar extends Vue {
        name: string = 'Calendar';
        appointments: any[] = [];

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

        goToProfile(role: number, id: string) {
            if (role == 1) {
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
