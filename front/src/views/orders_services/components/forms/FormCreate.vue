<template>
  <v-form>
    <!-- <form action="" method="post"></form> -->
    <v-row>
      <v-col cols="2">
        <validation-provider rules v-slot="{ errors }">
          <v-autocomplete
            :items="services"
            item-text="name"
            item-value="id"
            v-model="service_id"
            label="Escolha o Serviço"
            :error-messages="errors"
            clearable
          ></v-autocomplete>
        </validation-provider>
      </v-col>
      <v-col cols="4">
        <validation-provider rules="required" v-slot="{ errors }">
          <v-text-field label="Nome" v-model="call.name" :error-messages="errors[0]" readonly />
        </validation-provider>
      </v-col>
      <v-col cols="3">
        <validation-provider rules="required" v-slot="{errors, valid}">
          <v-text-field
            label="Prioridade"
            v-model="call.priority"
            :error-messages="errors[0]"
            :success="valid"
            readonly
          ></v-text-field>
        </validation-provider>
      </v-col>
      <v-col cols="3">
        <validation-provider rules="required" v-slot="{errors}">
          <v-text-field
            label="Status"
            :value="statu.toUpperCase()"
            :error-messages="errors[0]"
            readonly
          ></v-text-field>
        </validation-provider>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="4">
        <validation-provider rules="required" v-slot="{ errors, valid }">
          <v-text-field
            label="Origem"
            v-model="auth.profile.school"
            :error-messages="errors[0]"
            :success="valid"
            readonly
          />
        </validation-provider>
      </v-col>

      <v-col cols="3">
        <validation-provider rules="required" v-slot="{ errors, valid }">
          <v-text-field
            label="Destino"
            v-model="call.destiny"
            :error-messages="errors[0]"
            :success="valid"
            readonly
          />
        </validation-provider>
      </v-col>
      <v-col cols="3">
        <validation-provider rules="required" v-slot="{ errors, valid }">
          <v-text-field
            label="Sigla"
            v-model="call.initials"
            :error-messages="errors[0]"
            :success="valid"
            readonly
          ></v-text-field>
        </validation-provider>
      </v-col>
      <v-col cols="2">
        <validation-provider name="assunto" rules="required" v-slot="{ errors, valid }">
          <v-text-field
            label="Prazo"
            type="number"
            v-model="call.term"
            :error-messages="errors[0]"
            :success="valid"
            readonly
          />
        </validation-provider>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <validation-provider name="descricao" rules="required" v-slot="{ errors, valid }">
          <v-textarea
            clearable
            auto-grow
            outlined
            label="Descrição"
            v-model="call.description"
            :error-messages="errors[0]"
            :success="valid"
          />
        </validation-provider>
      </v-col>
    </v-row>

    <div class="d-flex justify-end">
      <v-btn color="primary" @click="$emit('salvar')" :disabled="!service_id">Salvar</v-btn>
    </div>
  </v-form>
</template>

<script>
import { ValidationProvider } from "vee-validate";

export default {
  props: ["services", "auth"],
  data() {
    return {
      statu: "a iniciar",
      service_id: "",
      call: {},
    };
  },
  components: { ValidationProvider },
  watch: {
    service_id(sv) {
      this.call = this.$store.getters.serviceById(sv);
      this.$emit("call_event", this.call);
      if (sv == null) this.call = {};
    },
  },
};
</script>

<style>
</style>