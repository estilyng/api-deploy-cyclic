<template>
  <v-form>
    <v-row>
      <v-col cols="6">
        <ValidationProvider>
          <v-text-field
            label="Nome"
            v-model="service.name"
            @input="$emit('service', service)"
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
            @input="$emit('service', service)"
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
            @input="$emit('service', service)"
            clearable
          ></v-text-field>
        </ValidationProvider>
      </v-col>
 <!--<v-col cols="6"> 
      <ValidationProvider>
        <v-select
          :items="destiny"
          v-model="service.service"
          label="Destino"
          clearable
        ></v-select>
      </ValidationProvider>
    </v-col>-->
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
            @input="$emit('service', service)"
            clearable
          ></v-text-field>
        </ValidationProvider>
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
import { ValidationProvider } from "vee-validate";
export default {
  data() {
    return {
      service: {
        destiny: ["Dpto Tecnologia da Informação1", "Setor Manutenção/Zeladoria"],
        initials: ["DTI", "SMZ"],
      },
      initials: [
        "DTI",//Departamento de Tecnologia da Informação
        "SMZ",//Setor de Manutenção e Zeladoria
       /* "Novo setor",
          "Outro seto",
        */
      ],
      prioritys: ["Baixa", "Média", "Alta", "Urgente"],
    };
  },
  components: { ValidationProvider },
};
</script>

<style>
</style>