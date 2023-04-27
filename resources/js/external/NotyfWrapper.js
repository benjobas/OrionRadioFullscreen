import { Notyf } from 'notyf'

export default class Alert {
    alert
    message
    duration

    constructor() {
        if(typeof window === 'undefined') return

        this.alert = new Notyf({
            duration: 4000,
            position: {
                x: 'center',
                y: 'top',
            },
            types: [
                {
                    type: 'warning',
                    background: 'orange',
                    icon: false
                },
                {
                    type: 'info',
                    background: 'blue',
                    icon: false
                }
            ]
        })
    }

    static success(message, duration) {
        return new Alert()._success(message, duration)
    }

    static warning(message, duration) {
        return new Alert()._warning(message, duration)
    }

    static info(message, duration) {
        return new Alert()._info(message, duration)
    }

    static error(message, duration) {
        return new Alert()._error(message, duration)
    }

    static alert(type, message, duration) {
        switch(type) {
            case 'success':
                return this.success(message, duration)
            case 'warning':
                return this.warning(message, duration)
            case 'info':
                return this.info(message, duration)
            case 'error':
                return this.error(message, duration)
        }
    }

    _success(message, duration) {
        if(!this.alert) return

        return this.alert.success({ message, duration })
    }

    _warning(message, duration) {
        if(!this.alert) return

        return this.alert.open({
            type: 'warning',
            message,
            duration
        })
    }

    _info(message, duration) {
        if(!this.alert) return

        return this.alert.open({
            type: 'info',
            message,
            duration
        })
    }

    _error(message, duration) {
        if(!this.alert) return

        return this.alert.error({ message, duration })
    }
}