import moment from "moment";

export default {
    methods: {
        expectedDay(created_at) {
            moment.locale("pt-br");
            let date = moment(created_at)
                .add(this.call.term, "days")
                .format("dddd");


            switch (date) {
                case "sábado":
                    date = moment(created_at)
                        .add(this.call.term + 2, 'days').format("dddd L");
                    break;

                case "domingo":
                    date = moment(created_at)
                        .add(this.call.term + 1, 'days').format("dddd L");
                    break;

                default:
                    date = moment(created_at)
                        .add(this.call.term, "days")
                        .format("dddd L");
                    break;
            }
            return date;
        }
    },


    filters: {
        formatDate(value) {
            moment.locale("pt-br");
            return moment(value).format("dddd L");
        },
        formatPercent(value) {
            return value.toLocaleString("pt-BR", { style: "percent" });
        },
    }
}