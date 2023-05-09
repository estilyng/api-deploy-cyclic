 <template>
  <v-snackbar
    v-model="toastErrorNotify"
    color="blue"
    vertical
    centered
    shaped
    timeout="-1"
    height="600"
    app
  >
    <v-row>
      <span class="d-flex align-center ma-2">
        <v-icon class="mr-2">mdi-alert</v-icon>
        O chamado "Nº
        {{ getcallError ? getcallError.call_id : "" }} -
        {{ getcallError ? getcallError.call_name : "" }}" não existe!
        Possivelmente tenha sido excluído.
      </span>

      <v-spacer></v-spacer>
      <v-btn icon color="white" @click.native="toastErrorNotify = false">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-row>
  </v-snackbar>
</template>
 
 <script>
import { mapGetters } from "vuex";

export default {
  computed: {
    toastErrorNotify: {
      get() {
        return this.$store.state.toastErrorNotify;
      },
      set() {
        this.$store.commit("updatetoastErrorNotify", !this.toastErrorNotify);
      },
    },

    ...mapGetters(["getcallError"]),
  },
};
</script>
 
 <style>
</style>