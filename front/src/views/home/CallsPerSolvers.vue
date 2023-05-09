 <template>
  <v-dialog v-model="dialog" max-width="900">
    <v-card v-click-outside="redirectHome">
      <v-card-title class=" d-flex flex-column">
        <span class="headline"> Chamados de {{ solver.name }} </span>
        <span class="subtitle-1">Total: {{ calls ? calls.length : 'Carregando' }} Chamados</span>
      </v-card-title>

      <v-card-text>
        <v-progress-linear
          :indeterminate="true"
          v-if="!calls"
        ></v-progress-linear>

        <v-data-table
          v-else
          :headers="headers"
          :items="calls"
          loading-text="caregando.."
          loader-height="2"
          :search="search"
          :items-per-page="pagination.itemsPerPage"
          :options.sync="pagination"
          :footer-props="{
            itemsPerPageText: 'Linhas por Página',
            itemsPerPageAllText: 'Todos',
            pageText: `${pagination.page} de ${numberOfPages}`,
          }"
        >
          <template v-slot:top>
            <v-text-field
              clearable
              label="Buscar"
              v-model="search"
              prepend-icon="mdi-magnify"
            ></v-text-field>
          </template>

          <template v-slot:item.statu="{ item }">
            <v-chip :color="colorStatus(item.statu)">
              {{ item.statu.toUpperCase() }}
            </v-chip>
          </template>

          <template v-slot:item.school="{ item }">
            {{ item.from }}
          </template>

          <template v-slot:item.actions="{ item }">
            <v-btn
              icon
              color="primary"
              @click="toDetailsCall(item.id)"
              :disabled="!isAdmin"
            >
              <v-icon>mdi-card-account-details</v-icon>
            </v-btn>
          </template>
        </v-data-table>
      </v-card-text>

      <!-- {{ customFilterSector }} -->
    </v-card>
  </v-dialog>
</template>
 
 <script>
import GlobalMixins from "@/mixins/globalMixins";
import AcessControllerMixins from "@/mixins/AcessControllerMixins";

export default {
  async mounted() {
    let calls = await this.$store.dispatch(
      "detailsCallsPerSolver",
      this.solver.id
    );
    this.calls = calls.data;
    this.concatItems();
  },
  props: ["solver"],
  mixins: [GlobalMixins, AcessControllerMixins],
  data() {
    return {
      dialog: true,
      calls: null,
      pagination: {},
      headers: [
        {
          text: "Número",
          align: "start",
          value: "id",
        },
        {
          text: "Nome",
          align: "start",
          value: "name",
        },
        {
          text: "Status",
          align: "start",
          value: "statu",
        },
        {
          text: "Setor de origem",
          align: "start",
          value: "from",
        },
        {
          text: "Ações",
          align: "start",
          value: "actions",
        },
      ],
    };
  },
  methods: {
    redirectHome() {
      this.$router.replace({ name: "home" });
    },
    toDetailsCall(id) {
      this.$router.push({
        name: "callsEdit",
        params: { id, solver: this.solver },
      });
    },

    concatItems() {
      this.calls.forEach((call) => {
        call.from = this.users.find(
          (user) => user.id === call.created_by
        ).profile.school;
      });
    },
  },
  computed: {
    search: {
      get() {
        return this.$store.getters.search;
      },
      set(value) {
        this.$store.commit("updateSerach", value);
      },
    },

    users() {
      return this.$store.getters.users;
    },

    numberOfPages() {
      return Math.ceil(this.calls.length / this.pagination.itemsPerPage);
    },
  },
};
</script>
 
 <style>
</style>