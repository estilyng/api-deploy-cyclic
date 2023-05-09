 <template>
  <v-snackbar v-model="value" :color="msg.color" bottom right :timeout="timeout" app>
    <v-row>
      <span class="d-flex align-center ma-2">{{ msg.message }}</span>

      <v-spacer></v-spacer>
      <v-btn icon color="white" @click.native="closeToast">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-row>
  </v-snackbar>
</template>
 
 <script>
export default {
  props: {
    msg: { type: Object, required: false },
  },
  watch: {
    "msg.toast"(newQuestion) {
      if (newQuestion) {
        this.value = true;

        setTimeout(() => {
          this.closeToast();
        }, this.timeout);
      }
    },
    value(newQuestion) {
      if (!newQuestion) {
        this.closeToast;
      }
    },
  },
  data() {
    return {
      value: false,
      timeout: 4000,
    };
  },
  methods: {
    closeToast() {
      this.value = false;
      this.msg.toast = false;
    },
  },
};
</script>
 
 <style>
</style>