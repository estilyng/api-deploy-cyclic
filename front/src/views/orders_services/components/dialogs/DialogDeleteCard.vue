<template>
  <div>
    <v-btn block color="red" class="white--text" @click.stop="dialog = true" :disabled="call.statu === 'concluído'"
      >Excluir</v-btn
    >

    <v-dialog v-model="dialog" max-width="550">
      <v-card>
        <v-card-title class="d-flex justify-center headline"
          >Confirmação de Exclusão</v-card-title
        >

        <v-card-text>
          <v-list>
            <v-list-item @click="() => {}">
              <v-list-item-title class="d-flex justify-center"
                >Tem certeza disso?</v-list-item-title
              >
            </v-list-item>
          </v-list>

          <v-alert
            type="warning"
            dense
            border="left"
            v-if="call.statu !== 'concluído'"
          >
            Chamado não concluído
          </v-alert>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color="teal accent-4" text @click="dialog = false"
            >Cancelar</v-btn
          >

          <v-btn
            color="red darken-1"
            text
            @click="
              deleteCall();
              dialog = false;
            "
            :disabled="call.statu !== 'concluído'"
            >Excluir</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  props: ["call"],
  data() {
    return {
      dialog: false,
    };
  },
  methods: {
    deleteCall() {
      this.$emit("deleteCall");
    },
  },
};
</script>

<style>
</style>