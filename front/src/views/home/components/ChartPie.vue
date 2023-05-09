<script>
import { Pie } from "vue-chartjs";
import { mixins } from "vue-chartjs";
const { reactiveProp } = mixins;

export default {
  extends: Pie,
  data() {
    return {
      labels: [],
      values: [],
    };
  },

  mixins: [reactiveProp],
  mounted() {
    this.renderChart(this.chartData, {
      responsive: true,
      maintainAspectRatio: true,
    });
  },
};
</script>

<style>
</style>