 <template>
  <card-default color="light-blue"> <!--Lembreta: Para ficar igual a Lista de Usários <card-default color="light-blue">-->
    <template v-slot:card-icon>
      <v-icon x-large>mdi-format-list-bulleted</v-icon>
    </template>

    <template v-slot:card-title>Lista de Serviços</template>

    <template v-slot:card-header-list-btnPlus>
      <dialog-add
        @storeService="loading = $event"
        @msgError="getMsgError($event)"
      />
    </template>
    <template v-slot:card-header-list-fieldSearch>
      <v-text-field clearable label="Buscar" v-model="search" prepend-icon="mdi-magnify"></v-text-field>
    </template>

    <template v-slot:card-body>
      <!-- msgs aqui! -->
      <!-- <ToastMsg @closeToast="clearMsg($event)" :msg="msg" /> -->
      <AlertMsg v-show="msg.errors" :msg="msg" />
      <!-- --------------- -->

      <v-pagination class="mb-3" v-model="pagination.page" :length="numberOfPages" circle></v-pagination>
      <v-data-table
        :headers="headers"
        :items="services"
        item-key="id"
        :loading="loading"
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
        <template v-slot:[`item.priority`]="{ item }">
          <v-chip
            :color="colorPriority(item.priority)"
            dark
            class="text-uppercase"
          >{{ item.priority }}</v-chip>
        </template>

        <template v-slot:[`item.actions`]="{ item }">
          <dialog-edit
            :service="item"
            @msgError="getMsgError($event)"
          />
          <dialog-delete
            :service_id="item.id"
            @msgError="getMsgError($event)"
          />
        </template>
      </v-data-table>
    </template>
  </card-default>
</template>
 
 <script>
import { mapState } from "vuex";
import DialogAdd from "./components/DialogAdd";
import DialogDelete from "./components/DialogDelete";
import DialogEdit from "./components/DialogEdit";
import CardDefault from "@/components/Card";
import AlertMsg from "../../components/AlertMsg";
// import ToastMsg from "../../components/ToastMsg";

import globalMixins from "@/mixins/globalMixins";

export default {
  created() {
    this.$store.dispatch("loadServices");
  },
  components: {
    DialogAdd,
    DialogDelete,
    DialogEdit,
    CardDefault,
    AlertMsg,
    // ToastMsg,
  },
  data() {
    return {
      headers: [
        {
          text: "CRIADO POR",
          value: "user.name",
        },
        { text: "SERVIÇO", value: "name" },
        { text: "PRIORIDADE", value: "priority" },
        { text: "DESTINO", value: "destiny" },
        { text: "PRAZO EM DIAS", value: "term" },
        { text: "SIGLA", value: "initials" },
        { text: "AÇÕES", value: "actions", sortable: false },
      ],
      search: "",
      pagination: {
        page: 1,
        itemsPerPage: 5,
      },
    };
  },
  mixins: [globalMixins],
  computed: {
    ...mapState(["loading"]),
    services() {
      return this.$store.getters.services;
    },
    numberOfPages() {
      return Math.ceil(this.services.length / this.pagination.itemsPerPage);
    },
  },
};
</script>
 
 <style>
</style>