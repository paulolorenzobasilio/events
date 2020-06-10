import Swal from "sweetalert2";

const mixin = {
    methods: {
        $_getNameOfDay(day) {
            return new Intl.DateTimeFormat("en-US", { weekday: "short" }).format(day);
        },
        $_notif(title, icon = "success") {
            Swal.fire({
                icon: icon,
                title: title,
                toast: true,
                position: "top-right",
                showConfirmButton: false,
                timer: 3000
            });
        },
    }
}

export default {
    install(Vue, options) {
        Vue.mixin(mixin);
    }
}