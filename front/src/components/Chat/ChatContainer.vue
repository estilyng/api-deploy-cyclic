 <template>
  <v-menu
    v-model="showMenu"
    :close-on-content-click="false"
    transition="scroll-y-reverse-transition"
    max-width="40%"
    width="30%"
    max-height="90%"
  >
  <!--
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        color="primary"
        v-bind="attrs"
        v-on="on"
        fab
        dark
        large
        fixed
        bottom
      >
        <v-icon dark> mdi-chat </v-icon>
      </v-btn>
    </template>-->
    
    <slot name="content">
      <FormValidChat
        v-if="currentComponent !== 'Chat'"
        @valid-chat="currentComponent = $event"
      />

      <v-expand-x-transition>
        <chat v-show="currentComponent === 'Chat'">
          <template v-slot:content>
            <v-container grid-list-xs>
              <v-btn text icon color="primary" @click="currentComponent = ''">
                <v-icon medium>mdi-arrow-left</v-icon>
              </v-btn>
              <ChatContent height="300px" />
            </v-container>
          </template>
        </chat>
      </v-expand-x-transition>
    </slot>
  </v-menu>
</template>
 
 <script>
import Chat from "./Chat";
import ChatContent from "./ChatContent";
import FormValidChat from "./FormValidChat";

import { mapGetters } from "vuex";
import AcessControllerMixins from "@/mixins/AcessControllerMixins";

export default {
  mixins: [AcessControllerMixins],
  data() {
    return {
      showMenu: false,
      currentComponent: "FormValidChat",
    };
  },
  components: {
    Chat,
    ChatContent,
    FormValidChat,
  },
  computed: {
    ...mapGetters(["getcurrentMessages"]),
  },
};
</script>
 
 <style>
</style>