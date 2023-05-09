import localforage from 'localforage'

export default {
    mounted() {
        localforage.getItem("helpDesk").then((value) => {
            return value.login.auth.roles.filter((item) => {
                if (item.name == "administrador" || item.name == "direcionador") {
                    this.isAdmin = true;
                    return item;
                } else if (item.name == "solucionador") {
                    this.isSolver = true;
                    return item;
                }
            });
        });

    },

    data() {
        return {
            disabled: false,
            isSolver: null,
            isAdmin: null,
        };
    },
}