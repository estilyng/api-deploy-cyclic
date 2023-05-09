 <template>
  <span>
    <v-btn small icon color="red" @click="dialog = true" :loading="load">
      <v-icon>mdi-delete</v-icon>
    </v-btn>

    <v-dialog v-model="dialog" max-width="500">
      <v-card>
        <v-card-title class="d-flex justify-center"
          >Exlcuir Serviço</v-card-title
        >
        <v-card-text class="text-center"
          >Tem Certeza que deseja excluir?</v-card-text
        >
        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn text color="primary" @click="dialog = false">NÃO</v-btn>
          <v-btn
            text
            color="red"
            @click="
              dialog = false;
              deleteService();
            "
            >SIM</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </span>
</template>
 
 <script>
import { mapMutations } from "vuex";
export default {
  props: ["service_id"],
  data() {
    return {
      dialog: false,
      load: false,
    };
  },
  methods: {
    ...mapMutations(["setLoading"]),
    async deleteService() {
      this.load = true;
      this.setLoading(true);
      try {
        await this.$store.dispatch("deleteService", this.service_id);
        this.$toast.success("Serviço excluído com sucesso!")
      } catch (error) {
        this.$emit("msgError", error.response.data.errors);
        this.$toast.error("O servidor detectou algum erro...")
      } finally {
        this.load = false;
        this.setLoading(false);
      }
    },
  },
};
</script>
 
 <style>
</style>