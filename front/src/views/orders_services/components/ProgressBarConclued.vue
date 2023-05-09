<template>
  <v-progress-linear
  
    color="#C6FF00"
    background-color="light-green lighten-5"
    :value="countProgressBar.total"
    height="12px"
    rounded
    stream
  >{{ conclued }}</v-progress-linear>
</template>

<script>
import DatesMixin from "../Mixins/DatesMixin";
import moment from "moment";

export default {
  props: ["call"],
  mixins: [DatesMixin],
  computed: {
    countProgressBar() {
      let search_horas = moment(this.call.created_at)
        .endOf("day")
        .fromNow()
        .indexOf("horas");

      let count_days = moment(this.call.created_at).endOf("day").fromNow();

      count_days = count_days.replace("há", "").replace("dias", "");

      if (search_horas > 0) {
        let daysOrHours = count_days.replace(/\D/g, "");
        let total = parseFloat(daysOrHours * 100) / (this.call.term * 24);
        return { total, daysOrHours: `há menos de ${daysOrHours} horas` };
      } else {
        let daysOrHours = count_days;
        let total = (100 / this.call.term) * count_days;
        return { total, daysOrHours: `há ${daysOrHours} dias` };
      }
    },
    conclued(){
      return `Concluído em ${moment(this.call.updated_at).format('LL')}` ;
    },
  },
};
</script>

<style>
</style>