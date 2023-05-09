 <template>
  <v-container>
    <strong> Entre com o número do chamado sobre o qual deseja tratar: </strong>
    <v-text-field
      clearable
      outlined
      rounded
      dense
      class="mt-4"
      min="0"
      type="number"
      v-model.number="numberCall"
      label="Digite o número do Chamado"
      @keydown.enter="validNumberCall"
    ></v-text-field>
    <v-card-actions class="d-flex justify-end">
      <v-btn
        block
        rounded
        dark
        color="info"
        @click="validNumberCall"
        :loading="loading"
      >
        OK
      </v-btn>
    </v-card-actions>

    <v-alert
      v-show="alert"
      v-model="alert"
      type="warning"
      icon="mdi-alert-circle-outline"
      :value="true"
      transition="fade-transition"
      dismissible
      dense
    >
      O chamado de nº {{ numberCallValidated }} não existe.
    </v-alert>
  </v-container>
</template>
 
 <script>
export default {
  data() {
    return {
      numberCall: null,
      loading: false,
      alert: false,
      numberCallValidated: null,
    };
  },
  computed: {
    toMessage: {
      get() {
        return this.$store.getters.getToMessage;
      },

      set(value) {
        this.$store.commit("UPDATE_TO_MESSAGE", value);
      },
    },
  },
  methods: {
    async validNumberCall() {
      this.loading = true;
      this.alert = false;
      try {
        const calls = await this.$store.dispatch("loadCalls");

        const call = calls.find((call) => call.id === this.numberCall);

        if (call) {
          const toMessage = {
            call_id: call.id,
            to: this.toMessage.to,
            from: this.toMessage.from,
            valid: true,
          };
          this.toMessage = toMessage;
          this.$store.commit("SET_CURRENT_MESSAGE_PER_CALL_ADMIN", toMessage);
        } else {
          this.alert = true;
          this.numberCallValidated = this.numberCall;
        }
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
 
 <style>
</style>