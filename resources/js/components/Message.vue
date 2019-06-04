<template>
    <div v-show="extraStr || (messages && Object.keys(messages).length)" :class="messageType + ' message'">
        <ul>
            <li v-show="extraStr">
                <span>{{ extraStr }}</span>
            </li>
            <li v-for="messagesArr in messages">
                <span v-for="message in messagesArr" class="message-item">
                    <a-icon v-if="messageType == 'error'" type="exclamation-circle" /><a-icon v-if="messageType == 'success'" type="check-circle" /><span>{{ message }}</span>
                </span>
            </li>
        </ul>
    </div>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    
    @Component
    export default class Message extends Vue {
        @Prop(Object) messages: object;
        @Prop(String) messageType: string;
        @Prop(String) extraStr: string;

        name: string = 'Message';
    }
</script>

<style lang="scss" scoped>
    .message {
        margin: 20px 0;
        padding: 15px;
        color: $light-color;
        border-radius: $default-border-radius;

        li, li .message-item {
            display: block;
            margin: 10px 0;
        }
        li .message-item span {
            vertical-align: middle;
        }
    }
    .success {
        background-color: $dark-primary-accent-color;
    }
    .error {
        background-color: $error-color;
    }
</style>
