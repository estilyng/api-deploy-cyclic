 <template>
  <span>
    <v-btn small icon color="primary" @click="dialog = true" :loading="loading">
      <v-icon>mdi-pencil</v-icon>
    </v-btn>

    <v-dialog v-model="dialog" max-width="700">
      <v-card>
        <v-card-title class="d-flex justify-center"
          >Atualizar Serviço</v-card-title
        >
        <v-card-text class="text-center">
          <v-form>
            <v-row>
              <v-col cols="6">
                <ValidationProvider>
                  <v-text-field
                    label="Nome"
                    v-model="service.name"
                    clearable
                  ></v-text-field>
                </ValidationProvider>
              </v-col>
              <v-col cols="6">
                <ValidationProvider>
                  <v-text-field
                    label="Descrição"
                    textarea
                    v-model="service.description"
                    clearable
                  ></v-text-field>
                </ValidationProvider>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="6">
                <ValidationProvider>
                  <v-text-field
                    label="Destino"
                    v-model="service.destiny"
                    clearable
                  ></v-text-field>
                </ValidationProvider>
              </v-col>
              <v-col cols="3">
                <ValidationProvider>
                  <v-autocomplete
                    :items="initials"
                    v-model="service.initials"
                    label="Sigla"
                    clearable
                  ></v-autocomplete>
                </ValidationProvider>
              </v-col>
              <v-col cols="3">
                <ValidationProvider>
                  <v-select
                    :items="prioritys"
                    v-model="service.priority"
                    label="Prioridades"
                    clearable
                  ></v-select>
                </ValidationProvider>
              </v-col>
            </v-row>

            <v-row>
              <v-col cols="4">
                <ValidationProvider>
                  <v-text-field
                    type="number"
                    label="Prazo em dias"
                    v-model="service.term"
                    clearable
                  ></v-text-field>
                </ValidationProvider>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn text color="red" @click="dialog = false">NÃO</v-btn>
          <v-btn
            text
            color="success"
            @click="
              dialog = false;
              updateService();
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
import { ValidationProvider } from "vee-validate";

export default {
  props: ["service"],
  data() {
    return {
      dialog: false,
      initials: [
        "DTI",//Departamento de Tecnologia da Informação
        "SMZ",//Setor de Manutenção e Zeladoria
       /* "SMO",//Setor Manutenção Odonto
        "ST",//Setor Transporte
      */
      ],
      prioritys: ["Baixa", "Média", "Alta", "Urgente"],
      loading: false,
    };
  },
  components: { ValidationProvider },
  methods: {
    ...mapMutations(["setLoading"]),
    ajustData() {
      delete this.service.user;
      const auth = this.$store.getters.auth;
      this.service.user_id = auth.id;
    },
    async updateService() {
      this.loading = true;
      this.setLoading(true);
      this.ajustData();

      try {
        await this.$store.dispatch("updateService", this.service);
        await this.$store.dispatch("loadServices");
        this.$toast.success("Serviço atualizado com sucesso!");
      } catch (error) {
        this.$toast.error("O servidor detectou algum erro...");
        this.$emit("msgError", error.response.data.errors);
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