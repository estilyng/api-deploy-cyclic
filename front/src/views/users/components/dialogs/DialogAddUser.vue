<template>
  <div>
    <v-col cols="7">
      <v-btn color="success" @click.stop="dialog = true">
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </v-col>
    <v-dialog v-model="dialog" max-width="600">
      <v-card>
        <v-card-title class="headline">Registrar Usuário</v-card-title>
        <validation-observer v-slot="{invalid}">
          <v-card-text>
            <validation-provider rules="required" v-slot="{errors}">
              <v-text-field
                label="Nome"
                type="text"
                v-model="user.name"
                :error-messages="errors[0]"
              ></v-text-field>
            </validation-provider>
          
            <validation-provider rules="required|email" v-slot="{errors}">
              <v-text-field
                label="Email"
                type="text"
                v-model="user.email"
                :error-messages="errors[0]"
              ></v-text-field>
            </validation-provider>

            <validation-provider rules="required" v-slot="{errors}">
              <v-text-field
                label="Senha"
                type="password"
                v-model="user.password"
                hint="Pelo menos 8 carácteres"
                :error-messages="errors[0]"
              ></v-text-field>
            </validation-provider>

            <validation-provider rules="required" v-slot="{errors}">
              <v-text-field
                label="Confirme a senha"
                hint="Pelo menos 8 carácteres"
                type="password"
                v-model="user.password_confirmation"
                :error-messages="errors[0]"
              ></v-text-field>
            </validation-provider>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red darken-1" text @click="dialog = false">Cancelar</v-btn>

            <v-btn color="green darken-1" text @click="dialog = false" :disabled="invalid">Registrar</v-btn>
          </v-card-actions>
        </validation-observer>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { ValidationObserver, ValidationProvider } from "vee-validate";
export default {
  name: "dialog-add-user",
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
        password_confirmation: ""
      },
      dialog: false
    };
  },
  components: { ValidationObserver, ValidationProvider }
};
</script>

<style>
</style>