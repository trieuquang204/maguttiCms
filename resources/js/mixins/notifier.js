export default {
    data: () => ({
        data: '',
    }),
    methods: {
        notify(message) {
            window.$.smkAlert(message);
        },
        notifyError(message) {
            window.$.smkAlert({
                text: message,
                type: 'danger',
                time: 3
            });
        }
    }
}
