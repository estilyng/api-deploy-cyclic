 <template>
  <!-- <v-card>
    <v-card-text> -->
  <v-container grid-list-xs>
    <chat :messages-props="messages">
      <template v-slot:top-bar>
        <!--<v-app-bar color="deep-purple accent-4 "></v-app-bar>-->
        <v-app-bar color="light-blue">
          <v-app-bar-nav-icon
            class="white--text"
            @click="drawer = !drawer"
          ></v-app-bar-nav-icon>
        </v-app-bar>
      </template>
      <template v-slot:sidebar>
        <ChatSideBar />
      </template>
      <template v-slot:content>
        <ChatContent />
      </template>
    </chat>
  </v-container>
  <!-- </v-card-text>
  </v-card> -->
</template>
 
 <script>
import Chat from "@/components/Chat/Chat";
import ChatSideBar from "@/components/Chat/ChatSideBar";
import ChatContent from "@/components/Chat/ChatContent";
import store from '../../store/index'

export default {
  async mounted() {
    // await this.$store.dispatch("loadUsers");
    await this.$store.dispatch("load_chat_user");
    await this.$store.dispatch("loadMessages");
  },
  beforeRouteEnter(to, from, next) {
    store.commit("CLEAN_CURRENT_MESSAGE");
    next();
  },
  components: {
    Chat,
    ChatSideBar,
    ChatContent,
  },
  data() {
    return {
      messages: [],
    };
  },
  computed: {
    drawer: {
      get() {
        return this.$store.getters.getDrawer;
      },

      set(value) {
        this.$store.commit("UPDATE_DRAWER", value);
      },
    },
  },
};
</script>
 
 <style>
</style>