 <template>
  <validation-observer v-slot="{ invalid }">
    <v-form>
      <v-col cols="12">
        <v-row>
          <v-col cols="6">
            <validation-provider rules="required" v-slot="{ errors }">
              <v-text-field
                label="Nome do usuário"
                type="text"
                v-model="user.name"
                :error-messages="errors[0]"
              ></v-text-field>
            </validation-provider>
          </v-col>
          <v-col cols="6">
            <validation-provider rules="required" v-slot="{ errors }">
              <v-text-field
                label="Nome Completo"
                v-model="user.full_name"
                :error-messages="errors[0]"
              ></v-text-field>
            </validation-provider>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="3">
            <validation-provider rules="required|email" v-slot="{ errors }">
              <v-text-field
                label="Email"
                type="text"
                v-model="user.email"
                :error-messages="errors[0]"
              ></v-text-field>
            </validation-provider>
          </v-col>
          <v-col cols="4">
            <validation-provider rules="required" v-slot="{ errors }">
              <v-select
                :items="roles"
                label="Função no Sistema"
                class="text-uppercase"
                multiple
                v-model="user.roles"
                :error-messages="errors[0]"
              ></v-select>
            </validation-provider>
          </v-col>
          <v-col cols="3">
            <validation-provider rules="required" v-slot="{ errors }">
              <!-- mudar "escola de origem" pra "setor de origem" -->
              <v-text-field
                label="Setor de Origem"
                v-model="user.school"
                :error-messages="errors[0]"
              ></v-text-field>
            </validation-provider>
          </v-col>
          <v-col cols="2">
            <validation-provider rules="required" v-slot="{ errors }">
              <v-text-field
                label="Cargo"
                v-model="user.office"
                :error-messages="errors[0]"
              ></v-text-field>
            </validation-provider>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="6">
            <validation-provider
              rules="required|min:8"
              vid="confirmation"
              v-slot="{ errors }"
            >
              <v-text-field
                label="Senha"
                type="password"
                v-model="user.password"
                hint="Pelo menos 8 carácteres"
                :error-messages="errors[0]"
              ></v-text-field>
            </validation-provider>
          </v-col>
          <v-col cols="6">
            <validation-provider
              rules="required|confirmed:confirmation"
              v-slot="{ errors }"
            >
              <v-text-field
                label="Confirme a senha"
                type="password"
                v-model="user.password_confirmation"
                :error-messages="errors[0]"
              ></v-text-field>
            </validation-provider>
          </v-col>
        </v-row>
        <v-row class="d-flex justify-center">
          <v-btn
            @click="$emit('submit', user)"
            color="primary"
            :loading="loading"
            :disabled="invalid"
            >Salvar</v-btn
          >
        </v-row>
      </v-col>
    </v-form>
  </validation-observer>
</template>
 
 <script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
export default {
  mounted() {
    this.$store.dispatch("loadRoles");
  },
  props: ["loading"],
  data() {
    return {
      user: {
        // name: "fabricio",
        // full_name: "fabricio santos",
        // email: "sat-fms@gmail.com",
        // roles: ["operador"],
        // office: 'analista',
        // school: "DTI",
        // password: 12345687,
        // password_confirmation: 12345678,
      },
    };
  },
  components: { ValidationProvider, ValidationObserver },
  computed: {
    roles() {
      return this.$store.getters.roles.map((r) => r.name);
    },
  },
};
</script>
 
 <style>
</style>