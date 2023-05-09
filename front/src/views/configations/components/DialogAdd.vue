 <template>
  <span>
    <v-btn large color="success" @click="dialog = true" :loading="loading">
      <v-icon>mdi-plus</v-icon>
    </v-btn>

    <v-dialog v-model="dialog" max-width="700">
      <v-card>
        <v-card-title primary-title>Novo Serviço</v-card-title>
        <v-card-text>
          <form-new-service @service="getServiceOfForm($event)" />
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text color="red" @click="dialog = false">SAIR</v-btn>
          <v-btn
            text
            color="success"
            @click="
              dialog = false;
              storeService();
            "
            >SALVAR</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </span>
</template>
 
 <script>
import FormNewService from "./_formNew";

import localForage from "localforage";
import { mapMutations } from "vuex";

export default {
  created() {
    localForage
      .getItem("helpDesk")
      .then((item) => {
        this.user_id = item.login.auth.id;
      })
      .catch(() => {
        this.user_id = null;
      });
  },
  data() {
    return {
      dialog: false,
      service: "",
      user_id: null,
      loading: false,
    };
  },
  components: { FormNewService },
  methods: {
    ...mapMutations(["setLoading"]),
    getServiceOfForm(event) {
      this.service = event;
    },
    async storeService() {
      this.service.user_id = this.user_id;
      this.loading = true;
      this.setLoading(true);

      try {
        await this.$store.dispatch("storeService", this.service);
        this.$toast.success("Serviço criado com sucesso!")
      } catch (error) {
        this.$toast.error("O servidor detectou algum erro...");
        this.$emit('msgError', error.response.data.errors)
      } finally {
        this.loading = false;
        this.setLoading(false);
      }
    },
  },
};
</script>
 
 <style>
</style>