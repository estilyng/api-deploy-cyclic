<template>
  <div>
    <router-view></router-view>
    <v-card width="100%" class="mt-5 elevation-4" tile>
      <v-card-title class="card-title-color">
        <div class="d-flex justify-space-around">
          <v-badge :color="colorPriority(call.priority)" class="mr-16">
            <span slot="badge">{{ call.priority }}</span>
          </v-badge>

          <v-badge color="success">
            <span slot="badge">{{ user ? user.profile.school : ''}}</span>
          </v-badge>
        </div>

        <v-spacer></v-spacer>
        <!-- <dialog-edit :call="call" /> -->
        <v-btn icon color="primary" :to="`/calls/${call.id}/edit`">
          <v-icon>mdi-card-account-details</v-icon>
        </v-btn>
        <dialog-delete :dialog="false" :call="call" />
      </v-card-title>

      <v-card-text>
        <v-row class="d-flex align-center">
          <v-col cols="6">
            <v-list>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title class="mb-2 headline"> Nº {{ call.id }} - {{ call.name }}</v-list-item-title>
                  <v-list-item-subtitle>Destino: {{ call.destiny }} - {{ call.initials }}</v-list-item-subtitle>
                  <v-list-item-subtitle>Prazo: {{ call.term }} dias</v-list-item-subtitle>
                  <v-list-item-subtitle>
                    Status:
                    <v-chip :color="colorStatus(call.statu)">{{ call.statu.toUpperCase() }}</v-chip>
                  </v-list-item-subtitle>
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-col>

          <v-col cols="6">
            <div class="d-flex justify-space-around">
              <span>{{ call.created_at | formatDate }}</span>
              <span class="headline">Previsão</span>
              <span>{{ expectedDay(call.created_at) }}</span>
            </div>
            <ProgressBarConclued v-if="call.statu == 'concluído'" :call="call" />
            <ProgressBar v-else :call="call" />
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import DialogDelete from "./dialogs/DialogDelete";
import ProgressBar from "./ProgressBar";
import ProgressBarConclued from "./ProgressBarConclued";

import DatesMixin from "../Mixins/DatesMixin";
import globalMixins from "@/mixins/globalMixins";

export default {
  props: ["call", "user_id"],
  data() {
    return {
      solverVar: null,
    };
  },
  components: {
    DialogDelete,
    ProgressBar,
    ProgressBarConclued,
  },
  mixins: [DatesMixin, globalMixins],
  computed: {
    user() {
      return this.$store.getters.usersById(this.user_id);
    },
  },
};
</script>

<style>
.card-title-color {
  background: #a3a7af;
 /* background: -webkit-linear-gradient(to right, #5b86e5, #36d1dc);
  background: linear-gradient(to right, #5b86e5, #36d1dc);*/
   /*
  background: -webkit-linear-gradient(to right, #5b86e5, #36d1dc);
  background: linear-gradient(to right, #5b86e5, #36d1dc);
  */
}
</style>