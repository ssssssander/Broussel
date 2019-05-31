<template>
    <div class="choose-buddy">
        <div class="box">
            <template v-if="Object.keys(users).length">
                <ul>
                    <li v-for="user in users" @click="select(user)">
                        <div>{{ user.name }}</div>
                    </li>
                </ul>
            </template>
            <template v-else>
                <p>Laden...</p>
            </template>
            <div v-show="Object.keys(selectedUser).length" class="detail">
                <div>{{ selectedUser.id }}</div>
                <div>{{ selectedUser.name }}</div>
                <div>{{ selectedUser.email }}</div>
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
        users: object[] = [];
        selectedUser: object = {};

        created() {
            this.getUsers();
        }

        getUsers() {
            this.$http({
                url: `auth/users`,
                method: 'GET'
            })
            .then((response: any) => {
                console.log(response);
                this.users = response.data.users_data;
            }, (error: any) => {
                this.$message.error('Er is iets misgegaan bij het ophalen van de gegevens');
            });
        }

        select(user: object) {
            this.selectedUser = user;
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
