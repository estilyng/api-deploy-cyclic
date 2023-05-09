<template>
  <v-container>
    <v-card tile>
      <v-card-title class="app-bar-color mb-5">
        <div class="white--text d-flex flex-column">
          <span class="headline">Bem-vindos</span>
          <p class="subtitle-1">Monitore o andamento dos seus chamados</p>
        </div>
      </v-card-title>

      <v-progress-linear
        v-if="loaded"
        class="d-flex justify-center align-baseline"
        indeterminate
        color="primary"
      ></v-progress-linear>

      <v-card-text v-else>
        <v-row class="d-flex align-center">
          <v-col cols="12">
            <v-card elevation="8" color="white">
              <v-card-title>Chamados Solucionados</v-card-title> 
              <v-card-text>
                <chart-bar :height="150" :chart-data="collectionChartBar" />
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>
</template>
 
<script>
import ChartBar from "./components/ChartBar";
import { mapGetters } from "vuex";

export default {
  async created() {
    this.loaded = true;
    await this.$store.dispatch("callPerUserAuth").then(() => {
      this.callPerUserAuth = this.getCallPerUserAuth;
      this.configChartBar();
      this.loaded = false;
    });
  },
  data() {
    return {
      collectionChartBar: null,
      callPerUserAuth: null,
      loaded: false,
    };
  },
  components: { ChartBar },
  computed: { ...mapGetters({ getCallPerUserAuth: "callPerUserAuth" }) },
  methods: {
    configChartBar() {
      this.collectionChartBar = {
        labels: ["Chamados"],
        datasets: [
          {
            label: "Concluido",
            backgroundColor: this.callPerUserAuth.concluded.color,
            data: [this.callPerUserAuth.concluded.value],
          },
          {
            label: "Paralisado",
            backgroundColor: this.callPerUserAuth.paralyzed.color,
            data: [this.callPerUserAuth.paralyzed.value],
          },
          {
            label: "Cancelado",
            backgroundColor: this.callPerUserAuth.canceled.color,
            data: [this.callPerUserAuth.canceled.value],
          },
          {
            label: "Atrasado",
            backgroundColor: this.callPerUserAuth.late.color,
            data: [this.callPerUserAuth.late.value],
          },
          {
            label: "A Iniciar",
            backgroundColor: this.callPerUserAuth.starting.color,
            data: [this.callPerUserAuth.starting.value],
          },
          {
            label: "Andamento",
            backgroundColor: this.callPerUserAuth.progress.color,
            data: [this.callPerUserAuth.progress.value],
          },
        ],
      };
    },
  },
};
</script>
 
 <style>
</style>