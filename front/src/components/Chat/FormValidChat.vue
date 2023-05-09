 <template>
  <v-card max-height="100%" height="100%" min-height="500" dark color="primary">
    <v-container>
      <strong>
        Entre com o número do chamado sobre o qual deseja tratar:
      </strong>
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
        v-show="showAlert"
        v-model="showAlert"
        type="warning"
        icon="mdi-alert-circle-outline"
        :value="true"
        transition="fade-transition"
        dismissible
        dense
      >
        O chamado de nº {{ numberCallCopy }} não existe.
      </v-alert>
    </v-container>
  </v-card>
</template>
 
 <script>
// import localforage from "localforage";

export default {
  data() {
    return {
      numberCall: null,
      numberCallCopy: null,
      loading: false,
      showAlert: false,
    };
  },
  methods: {
    async validNumberCall() {
      this.loading = true;
      this.alert = false;
      try {
        const calls = await this.$store.dispatch("loadCalls");

        const call = calls.find((call) => call.id === this.numberCall);

        if (call) {
          this.setCurrentMessages(call);
        } else {
          this.showAlert = true;
          this.numberCallCopy = this.numberCall;
        }
      } finally {
        this.loading = false;
      }
    },

    async setCurrentMessages(call) {
      await this.$store.dispatch("loadMessages");

      this.$store.commit(
        "SET_CURRENT_MESSAGE",
        this.findUserSolverOfCall(call)
      );
      this.$emit("valid-chat", "Chat");
    },

    findUserSolverOfCall(call) {
      const user = call.users.map((user) => {
        return this.$store.getters.usersById(user.id);
      });

      console.log(user)

      // const user = roles
      //   .filter((role) => role.name === "solucionador")
      //   .map((role) => {
      //     return this.$store.getters.usersById(role.pivot.model_id);
      //   });

      // console.log("findUserSolverOfCall", user[0]);

      return user[0];
    },
  },
};
</script>
 
 <style>
</style>