<template>
  <div>
    <v-progress-linear
      v-if="call.statu == 'concluído'"
      :color="countProgressBar.total < 50 ? 'deep-purple accent-4' : 'red'"
      :value="countProgressBar.total"
      height="12px"
      rounded
      stream
      >{{ countProgressBar.daysOrHours }}</v-progress-linear
    >

    <v-progress-linear
      v-else
      :color="countProgressBar.total < 50 ? 'deep-purple accent-4' : 'red'"
      :value="countProgressBar.total"
      height="12px"
      rounded
      stream
      >{{ countProgressBar.daysOrHours }}</v-progress-linear
    >
  </div>
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
        return {
          total,
          daysOrHours: `Criado há menos de ${daysOrHours} horas`,
        };
      } else {
        let daysOrHours = count_days.split(" ").map((work) => {
          if (work == "dia") {
            return (work = "");
          } else return work
        }).join(' ');
        let total = (100 / this.call.term) * count_days;
        return { total, daysOrHours: `Criado há ${daysOrHours} dias` };
      }
    },
  },
};
</script>

<style>
</style>