export default {
    data() {
        return {
            msg: {
                type: "error",
                toast: false,
                color: "",
                errors: "",
                success: "",
            },
        }
    },
    methods: {
        colorPriority(priority) {
            let color = "";
            if (priority == "Urgente") color = "red";
            if (priority == "Alta") color = "yellow darken-2";
            if (priority == "Média") color = "blue lighten-2";
            if (priority == "Baixa") color = "purple";
            return color;
        },
        colorStatus(statu) {
            let color = "";
            if (statu == "a iniciar") color = "#B2DFDB";
            if (statu == "andamento") color = "#FFF9C4";
            if (statu == "atrasado") color = "#EF9A9A";
            if (statu == "paralisado") color = "#FFEB3B";
            if (statu == "concluído") color = "#C6FF00";
            if (statu == "cancelado") color = "#BBDEFB";
            return color;
        },

        getMsgError(errors) {
            this.msg.type = "error";
            this.msg.toast = true;
            this.msg.color = "error";
            this.msg.errors = errors;
            this.msg.message = "Dados inválidos";
        },
        clearMsg(event) {
            if (event) {
                this.msg.type = null;
                this.msg.toast = false;
                this.msg.color = null;
                this.msg.errors = null;
                this.msg.message = null;
            }
        },
    }
}