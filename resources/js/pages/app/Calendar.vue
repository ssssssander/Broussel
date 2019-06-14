<template>
    <div class="calendar">
        <a-calendar>
            <ul class="events" slot="dateCellRender" slot-scope="value">
                <li v-for="appointment in getAppointmentsByValue(value)" :key="appointment.id">
                    <span @click="goToProfile(appointment.person_role, appointment.person_id)" class="appointment"><span class="dot"></span>Van {{ appointment.time_from }} tot {{ appointment.time_to }}: {{ appointment.person_name }}</span>
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
                console.log(appointment.day,value.format('YYYY-MM-DD'));
                if (appointment.day == value.format('YYYY-MM-DD')) {
                    filteredAppointments.push(appointment);
                    console.log(filteredAppointments);
                }
            }

            return filteredAppointments;
        }

        onPanelChange(value: any, mode: any) {
            console.log(value, mode);
        }

        onSelect(value: any) {
            console.log(value);
        }

        goToProfile(role: number, id: string) {
            if (role == 1) {
                this.$router.push({ name: 'buddy-detail', params: { id: id } })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .appointment {
        font-weight: bold;
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
