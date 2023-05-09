<template>
  <div>
    <v-btn icon color="red" @click.stop="dialog = true" :loading="loading">
      <v-icon>mdi-delete</v-icon>
    </v-btn>

    <v-dialog v-model="dialog" max-width="550">
      <v-card>
        <v-card-title class="d-flex justify-center headline"
          >Confirmação de Exclusão</v-card-title
        >

        <v-card-text>
          <v-list three-line>
            <v-list-item @click="() => {}">
              <v-list-item-content class="text-center">
                <v-list-item-title>
                  Chamado nº {{ call.id }} - {{ call.name }}
                </v-list-item-title>
                <v-list-item-subtitle>
                  Destino {{ call.destiny }}
                </v-list-item-subtitle>
                <v-list-item-subtitle>
                  Prazo {{ call.term }} dias
                </v-list-item-subtitle>
                <v-list-item-subtitle>
                  <v-chip :color="colorStatus(call.statu)">{{
                    call.statu.toUpperCase()
                  }}</v-chip>
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>

          <v-alert
            v-if="call.statu !== 'concluído'"
            type="warning"
            dense
            border="left"
          >
            Chamado não concluído
          </v-alert>
          <h2 class="text-center">Tem certeza disso ?</h2>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color="teal accent-4" text @click="dialog = false"
            >Cancelar</v-btn
          >

          <v-btn
            color="red darken-1"
            text
            @click="deleteCall(call.id)"
            :disabled="disabilited()"
            >Excluir</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import globalMixins from "@/mixins/globalMixins";
import AccessControllerMixin from "@/mixins/AcessControllerMixins";

export default {
  props: ["call"],
  data() {
    return {
      dialog: false,
      loading: false,
    };
  },
  methods: {
    deleteCall(id) {
      this.dialog = false;
      this.loading = true;
      this.$store
        .dispatch("deleteCall", id)
        .then(() => {
          this.loading = false;
        })
        .catch((error) => {
          console.log(error);
          this.loading = false;
        });
    },
    disabilited() {
      if (this.call.statu !== "concluído") return true;
      if (!this.isAdmin) return true;
    },
  },
  mixins: [globalMixins, AccessControllerMixin],
};
</script>

<style>
</style>