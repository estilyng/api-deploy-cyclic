 <template>
  <div
    :style="`height: ${height}; max-height: ${height}; `"
    id="scroll-target"
    class="overflow-y-auto pa-0"
  >
    <img
      v-if="getcurrentMessages.length == 0"
      src="../../assets/images/no_data.png"
      height="100%"
      width="100%"
    />

    <v-row v-for="(item, index) in getcurrentMessages" :key="index">
      <v-col
        class="'mr-2 d-flex"
        :class="[
          index === 0 ? 'pt-3' : 'pa-0 pl-3 pr-3',
          item.from === auth.id ? 'justify-end' : 'justify-start',
        ]"
      >
        <v-alert
          dense
          :color="item.from === auth.id ? 'info' : 'blue-grey lighten-4'"
          min-width="50%"
          :value="true"
          rounded="xl"
          class="ml-2 mr-2"
          :class="[
          item.from === auth.id ? 'rounded-br-0' : 'rounded-bl-0 ',
          index === 0 ? 'mt-2' : ''
          ]"
        >
          <!-- content -->
          <div class="text-justify">
            <p>{{ searchUser(item.from).name }}:</p>
            {{ item.content }}
            <!-- timestamp -->
            <div class="subtitle-2 font-weight-light text-right">
              {{ formatDate(item.created_at) }}
            </div>
          </div>
        </v-alert>
      </v-col>
    </v-row>
  </div>
</template>
 
 <script>
import { mapGetters } from "vuex";
import localforage from "localforage";
import moment from "moment";

export default {
  props: {
    height: { type: String, required: false, default: "450px" },
  },
  mounted() {
    localforage.getItem("helpDesk").then((item) => {
      this.auth = item.login.auth;
    });
  },
  updated() {
    this.scrollToEnd();
  },

  data() {
    return {
      auth: {},
    };
  },
  computed: {
    ...mapGetters(["getcurrentMessages", "getSendMessage"]),
  },

  methods: {
    formatDate(date) {
      moment.locale("pt-br");
      return moment(date).format("L LTS");
    },

    scrollToEnd() {
      this.$el.scrollTop = this.$el.lastElementChild.offsetTop;
    },

    searchUser(id) {
      const user = this.$store.getters.users.find((user) => user.id === id);
      return user;
    },
  },
};
</script>
 
 <style>
</style>