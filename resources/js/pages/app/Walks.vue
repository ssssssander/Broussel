<template>
    <div class="walks">
        <div v-show="appointments.length">
            <div v-for="appointment in appointments">
                Op {{ $moment(appointment.day).format('DD/MM/YYYY') }} van {{ $moment(appointment.time_from, 'HH:mm:ss').format('HH:mm') }} tot {{ $moment(appointment.time_to, 'HH:mm:ss').format('HH:mm') }} met
                <router-link :to="{ name: 'buddy-detail', params: { id: appointment.buddy_id } }" class="link">{{ appointment.buddy_name }}</router-link>.
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class Walks extends Vue {
        name: string = 'Walks';
        appointments: any = [];

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
    }
</script>

<style lang="scss" scoped>
    
</style>
