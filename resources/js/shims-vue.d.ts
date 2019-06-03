declare module "*.vue" {
    import Vue from 'vue';
    export default Vue;
}

declare module 'ant-design-vue/lib/message' {
    import { Message } from 'ant-design-vue/types/message';
    const message: Message;
    export default Message;
}

declare module 'ant-design-vue/lib/notification' {
    import { Notification } from 'ant-design-vue/types/notification';
    const notification: Notification;
    export default notification;
}

declare module 'ant-design-vue/lib/icon' {
    import { Icon } from 'ant-design-vue/types/icon';
    const icon: Icon;
    export default icon;
}

declare module 'ant-design-vue/lib/date-picker' {
    import { DatePicker } from 'ant-design-vue/types/date-picker/date-picker';
    const datePicker: DatePicker;
    export default datePicker;
}

declare module 'ant-design-vue/lib/time-picker' {
    import { TimePicker } from 'ant-design-vue/types/time-picker';
    const timePicker: TimePicker;
    export default timePicker;
}

declare module 'ant-design-vue/lib/calendar' {
    import { Calendar } from 'ant-design-vue/types/calendar';
    const calendar: Calendar;
    export default calendar;
}
