<template>
<v-card
    :width="$vuetify.breakpoint.mobile ? '100%' : '50%'"
    height="100%"
    tile
  > 
    <v-card-title class="d-flex justify-center app-bar-color white--text"
      >Login
    </v-card-title
    >
    <validation-observer v-slot="{ invalid }">
      <v-card-text :class="$vuetify.breakpoint.mobile ? 'ma-0' : 'mt-12'">
        <v-alert v-show="error" dense type="error" class="mt-2">{{
          error
        }}</v-alert>

        <validation-provider rules="required" v-slot="{ errors }">
          <v-text-field
            prepend-icon="mdi-email"
            v-model="user.login"
            @keyup.enter="login"
            label="Informe E-mail ou Nome do usuário"
            :error-messages="errors[0]"
          ></v-text-field>
        </validation-provider>
        <validation-provider rules="required" v-slot="{ errors }">
          <v-text-field
            prepend-icon="mdi-lock-question"
            label="Senha"
            hint="Informe pelo menos 8 carácteres"
            min="8"
            type="password"
            @keyup.enter="login"
            v-model="user.password"
            :error-messages="errors[0]"
          ></v-text-field>
        </validation-provider>
      </v-card-text>
      <v-card-actions>
        <v-btn
          block
          text
          @click.prevent="login"
          :disabled="invalid"
          color="primary"
          :loading="loading"
          >Acessar</v-btn
        >
      </v-card-actions>
    </validation-observer>
  </v-card>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
export default {
  components: { ValidationProvider, ValidationObserver },
  data() {
    return {
      user: {
        login: "",
        password: "",
      },
      loading: false,
      error: "",
    };
  },
  methods: {
    login() {
      this.loading = true;
      this.$store
        .dispatch("login", this.user)
        .then((resp) => {
          this.loading = false;
          if (!resp.data.status) {
            this.$router.replace("/");
          } else {
            console.log(resp.data.message);
            this.error = resp.data.message;
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },
    clearError() {
      this.error = null;
    },
  },
};
</script>

<style>
</style>