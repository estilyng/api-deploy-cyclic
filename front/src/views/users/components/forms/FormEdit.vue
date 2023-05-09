 <template>
  <div>
    <v-skeleton-loader v-if="ridingComponent" :loading="true" class="mx-auto" type="article" tile></v-skeleton-loader>
    <v-skeleton-loader v-if="ridingComponent" :loading="true" class="mx-auto" type="article" tile></v-skeleton-loader>
    <v-skeleton-loader v-if="ridingComponent" :loading="true" class="mx-auto" type="article" tile></v-skeleton-loader>

    <validation-observer v-else>
      <v-form>
        <v-col cols="12">
          <v-row>
            <v-col cols="6">
              <validation-provider rules="required" v-slot="{errors}">
                <v-text-field
                  label="Nome do usuário"
                  type="text"
                  v-model="user.name"
                  :error-messages="errors[0]"
                  clearable
                ></v-text-field>
              </validation-provider>
            </v-col>
            <v-col cols="6">
              <validation-provider rules="required" v-slot="{errors}">
                <v-text-field
                  label="Nome Completo"
                  v-model="user.profile.full_name"
                  :error-messages="errors[0]"
                  clearable
                ></v-text-field>
              </validation-provider>
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="3">
              <validation-provider rules="required|email" v-slot="{errors}">
                <v-text-field
                  label="Email"
                  type="text"
                  v-model="user.email"
                  :error-messages="errors[0]"
                  clearable
                ></v-text-field>
              </validation-provider>
            </v-col>
            <v-col cols="4">
              <validation-provider rules="required" v-slot="{errors}">
                <v-select
                  :items="roles"
                  v-model="user.roles"
                  item-text="name"
                  item-value="name"
                  label="Função no Sistema"
                  class="text-uppercase"
                  multiple
                  clearable
                  :error-messages="errors[0]"
                ></v-select>
              </validation-provider>
            </v-col>
            <v-col cols="3">
              <validation-provider rules="required" v-slot="{errors}">
                <v-text-field
                  label="Setor de Origem"
                  v-model="user.profile.school"
                  :error-messages="errors[0]"
                  clearable
                ></v-text-field>
              </validation-provider>
            </v-col>
            <v-col cols="2">
              <validation-provider rules="required" v-slot="{errors}">
                <v-text-field
                  label="Cargo"
                  v-model="user.profile.office"
                  :error-messages="errors[0]"
                  clearable
                ></v-text-field>
              </validation-provider>
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="6">
              <validation-provider rules="min:8" vid="confirmation" v-slot="{errors}">
                <v-text-field
                  label="Nova senha"
                  type="password"
                  v-model.lazy="user.password"
                  hint="Pelo menos 8 carácteres"
                  :error-messages="errors[0]"
                  clearable
                ></v-text-field>
              </validation-provider>
            </v-col>
            <v-col cols="6">
              <validation-provider rules="confirmed:confirmation" v-slot="{errors}">
                <v-text-field
                  label="Confirme a nova senha"
                  type="password"
                  v-model.lazy="user.password_confirmation"
                  :error-messages="errors[0]"
                  clearable
                ></v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          <v-row>
            <v-col cols="6">
              <!-- <v-btn block @click="submitDelete()" color="red" class="white--text">Excluir</v-btn> -->
              <dialog-delete :user_id="id"></dialog-delete>
            </v-col>

            <v-col cols="6">
              <v-btn block @click="submitUpdate()" color="primary" :loading="loading">Salvar</v-btn>
            </v-col>
          </v-row>
        </v-col>
      </v-form>
    </validation-observer>
  </div>
</template>
 
 <script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import DialogDelete from "../dialogs/DialogDeleteUser";

export default {
  beforeCreate() {
    this.$store.dispatch("loadUsers").then(() => {
      this.$store.dispatch("loadRoles").then(() => {
        this.ridingComponent = false;
      });
    });
  },
  props: ["id", "loading"],
  data() {
    return {
      ridingComponent: true,
    };
  },
  components: {
    ValidationProvider,
    ValidationObserver,
    DialogDelete,
  },
  computed: {
    user() {
      return this.$store.getters.usersById(this.id);
    },
    roles() {
      return this.$store.getters.roles;
    },
  },
  watch: {
    user(olds, lasts) {
      // config value initial for user.roles
      if (olds) {
        const equals = olds.roles.filter((item) => {
          return lasts.roles.filter((last) => last.name == item.name);
        });

        if (equals) {
          const roles = equals.map((r) => r.name);
          delete olds.roles;
          delete olds.profile.user_id;
          delete olds.profile.id;
          olds.roles = roles;
        }
      }
    },
  },
  methods: {
    submitUpdate() {
      this.$emit("submitUpdate", this.user);
    },
    submitDelete() {
      this.$emit("deleteUser", this.user.id);
    },
  },
};
</script>
 
 <style>
</style>