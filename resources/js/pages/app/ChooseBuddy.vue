<template>
    <div class="choose-buddy">
        <div class="box">
            <h1>Kies je buddy</h1>
            <template v-if="Object.keys(buddies).length">
                <ul>
                    <li v-for="buddy in buddies" @click="select(buddy)">
                        <div>{{ buddy.name }}</div>
                    </li>
                </ul>
            </template>
            <template v-else>
                <p>Laden...</p>
            </template>
            <div v-show="Object.keys(selectedBuddy).length" class="detail">
                <div>{{ selectedBuddy.id }}</div>
                <div>{{ selectedBuddy.name }}</div>
                <div>{{ selectedBuddy.email }}</div>
                <button class="btn">Kies</button>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class ChooseBuddy extends Vue {
        name: string = 'ChooseBuddy';
        buddies: object[] = [];
        selectedBuddy: object = {};

        created() {
            this.getBuddies();
        }

        getBuddies() {
            this.$http({
                url: `auth/buddies`,
                method: 'get'
            })
            .then((response: any) => {
                this.buddies = response.data.buddies_data;
            }, (error: any) => {
                this.$message.error('Er is iets misgegaan bij het ophalen van de gegevens');
            });
        }

        select(buddy: object) {
            this.selectedBuddy = buddy;
        }
    }
</script>

<style lang="scss" scoped>
    ul {
        display: inline-block;
        width: 33%;

        li {
            display: block;
            cursor: pointer;
            border: 1px solid black;
            margin: 5px 0;
        }
    }
    .detail {
        display: inline-block;
        vertical-align: top;
        width: 66%;
    }
</style>
