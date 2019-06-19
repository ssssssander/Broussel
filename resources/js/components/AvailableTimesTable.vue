<template>
    <table class="available-times-table">
        <thead>
        <tr>
            <th>{{ 'vue.day' | trans }}</th>
            <th>{{ 'validation.attributes.from' | trans }}</th>
            <th>{{ 'validation.attributes.to' | trans }}</th>
        </tr>
        </thead>
        <tbody>
        <template v-for="availableTime in availableTimes">
            <tr v-if="availableTime.available">
                <td>{{ 'vue.' + availableTime.day | trans }}</td>
                <td>{{ availableTime.from }}</td>
                <td>{{ availableTime.to }}</td>
            </tr>
        </template>
        </tbody>
    </table>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    
    @Component
    export default class AvailableTimesTable extends Vue {
        @Prop() availableTimes: any;

        name: string = 'AvailableTimesTable';
    }
</script>

<style lang="scss" scoped>
    .available-times-table {
        border-collapse: collapse;
        width: 100%;

        td, th {
            border: $light-border;
            border-radius: $default-border-radius;
            text-align: left;
            padding: 12px;
        }

        tr:nth-child(even) {
            background-color: $gray-color;
        }
    }
</style>
