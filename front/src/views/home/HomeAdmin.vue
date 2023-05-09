<template>
  <v-container>
    <router-view></router-view>
    <v-card tile color="background-card">
      <v-card-title class="app-bar-color">
        <div class="white--text d-flex flex-column">
          <span class="headline">SAT-SAÚDE</span>
          <p class="subtitle-1">Sistema de Atendimento Técnico</p>
        </div>
      </v-card-title>

      <v-progress-linear
        v-if="loaded"
        class="d-flex justify-center align-baseline"
        indeterminate
        color="primary"
      ></v-progress-linear>

      <v-card-text v-else>
        <v-row
          class="d-flex align-center py-4"
          :class="$vuetify.breakpoint.mobile ? 'flex-column' : ''"
        >
          <v-col :cols="$vuetify.breakpoint.mobile ? '' : 8">
            <v-card elevation="8" color="white">
              <v-card-title>Chamados por solucionador</v-card-title>
              <v-card-text>
                <chart-bar
                  :height="$vuetify.breakpoint.mobile ? 500 : 150"
                  :chart-data="collectionChartBar"
                />
              </v-card-text>
            </v-card>
          </v-col>
          <v-col :cols="$vuetify.breakpoint.mobile ? '' : 4">
            <v-card elevation="8" color="white">
              <v-card-title>
                <v-chip class="ma-2 headline" color="blue lighten-5"
                  >Total: {{ calls.length }} Chamados</v-chip
                >
              </v-card-title>
              <v-card-text>
                <chart-pie :chart-data="collectionChartPie" :height="300" />
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
   <!--<v-row> 
       <v-col cols="12">
        <v-card elevation="8" color="white">
              <v-card-title>
                <div class="d-flex flex-column">
                  <span>Avaliação Equipe Técnica</span>
                  <span class="body-2">
                    Baseado nas pontuações das respostas enviadas aos
                    usuários. <br />
                    A contagem inicia-se a partir de 5 notas
                  </span>
                </div>
              </v-card-title>
              <v-card-subtitle class="pt-0 mt-0"> </v-card-subtitle>
              <v-card-text class="d-lg-flex justify-lg-space-around flex-wrap">
                <Avatar
                  v-for="(solver, i) in solvers"
                  :key="i"
                  :solver="solver"
                ></Avatar>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>-->
      </v-card-text>

      <v-card-actions class="d-flex justify-end">
        <span class="body-2">
          <DialogSignature />
        </span>
      </v-card-actions>
    </v-card>
  </v-container>
</template>
 
<script>
import ChartPie from "./components/ChartPie";
import ChartBar from "./components/ChartBar";
//import Avatar from "./components/Avatar";
import DialogSignature from "./components/DialogSignature";
import { mapGetters } from "vuex";

export default {
  async created() {
    this.loaded = true;
    // this.$store.dispatch("loadUsers");
    // this.$store.dispatch("loadAllResponses");
    this.calls = await this.$store.dispatch("loadCalls");
    await this.$store.dispatch("statusAllCalls").then((statusAllCalls) => {
      this.$store.dispatch("callPerUserSolver").then(() => {
        this.statusAllCalls = statusAllCalls;
        this.callPerUser = this.getcallPerUser;
        this.configChartPie();
        this.configChartBar();
        this.loaded = false;
      });
    });
  },
  data() {
    return {
      collectionChartPie: null,
      collectionChartBar: null,
      statusAllCalls: null,
      callPerUser: null,
      loaded: false,
      calls: null,
    };
  },
  components: { ChartPie, ChartBar, /*Avatar*/ DialogSignature },
  computed: {
    ...mapGetters({
      getcallPerUser: "callPerUserSolver",
      users: "users",
    }),

    solvers() {
      let solvers = [];
      this.users.map((user) => {
        return user.roles.filter((role) => {
          if (role.name === "solucionador") {
            solvers.push(user);
          }
        });
      });
      return solvers;
    },
  },
  methods: {
    configChartPie() {
      this.collectionChartPie = {
        labels: this.statusAllCalls.map((item) => item.text),
        datasets: [
          {
            label: this.statusAllCalls.map((item) => item.text.toUpperCase()),
            backgroundColor: this.statusAllCalls.map((item) => item.color),
            data: this.statusAllCalls.map((item) => item.value),
          },
        ],
      };
    },

    configChartBar() {
      this.collectionChartBar = {
        labels: this.callPerUser.map((item) => item.user),
        datasets: [
          {
            label: "Concluído",
            backgroundColor: "#C6FF00",
            data: this.callPerUser.map((item) => item.concluded),
          },
          {
            label: "Paralisado",
            backgroundColor: "#FFEB3B",
            data: this.callPerUser.map((item) => item.paralyzed),
          },
          {
            label: "Cancelado",
            backgroundColor: "#BBDEFB",
            data: this.callPerUser.map((item) => item.canceled),
          },
          {
            label: "Atrasado",
            backgroundColor: "#EF9A9A",
            data: this.callPerUser.map((item) => item.late),
          },
          {
            label: "A Iniciar",
            backgroundColor: "#43A047",
            data: this.callPerUser.map((item) => item.starting),
          },
          {
            label: "Andamento",
            backgroundColor: "#FFF9C4",
            data: this.callPerUser.map((item) => item.progress),
          },
        ],
      };
    },
  },
};
</script>
 
 <style>
.background-card {
  background: #E6E6E6;
  background: -webkit-linear-gradient(to right, #b9bcbb, #a3a7af, #909097);
  /*background: -webkit-linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);*/
  background: linear-gradient(to right, #b9bcbb, #a3a7af, #909097);
  /*background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);*/
}
</style>