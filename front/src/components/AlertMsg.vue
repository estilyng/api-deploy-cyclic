 <template>
  <v-alert :type="msg.type" dismissible>
    <template v-if="msg.errors">
      <div v-for="(error , i) in msg.errors" :key="i">
        <v-icon>mdi-circle-small</v-icon>
        {{ error[0] }}
      </div>
    </template>

    <span v-else>{{ msg.message }}</span>

    <template v-slot:close>
      <v-btn icon color="white" @click="clearMsg()">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </template>
  </v-alert>
</template>
 
 <script>
export default {
  props: {
    msg: { type: [Object], required: false },
  },
  watch: {
    "msg.success"(newQuestion) {
      if (newQuestion) {
        console.log('msg success', this.msg.success)
        this.msg.errors = null;
      }
    },
  },
  methods: {
    clearMsg() {
      this.msg.errors = null;
      this.msg.success = false;
    },
  },
};
</script>
 
 <style>
</style>