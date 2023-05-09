 
 <script>
import { Bar } from "vue-chartjs";
import { mixins } from "vue-chartjs";
const { reactiveProp } = mixins;

export default {
  extends: Bar,
  mixins: [reactiveProp],
  mounted() {
    this.renderChart(this.chartData, {
      responsive: true,
      maintainAspectRatio: true,
      onClick: (point, event) => {
        const solverChartName = event[0]._model.label;

        console.log("solverChart", solverChartName);

        const solver = this.$store.getters.users.find(
          (user) => user.name === solverChartName
        );

        if (solver) {
          this.$router
            .replace({ name: "callsSolver", params: { id: solver.id, solver } })
            .catch(() => {});
        }
      },
      hover: {
        onHover: (event, chartElement) => {
          event.target.style.cursor = chartElement[0] ? "pointer" : "default";
        },
      },
      // scales: {
      //   yAxes: [
      //     {
      //       ticks: {
      //         callback: function (value, index, values) {
      //           console.log(index, value ,values)
      //           console.log(this.chartData)
      //           return value;
      //         },
      //       },
      //     },
      //   ],
      // },
    });
  },
};
</script>
 
 <style>
</style>