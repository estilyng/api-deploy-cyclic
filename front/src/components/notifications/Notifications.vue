 <template>
  <div>
    <v-subheader>Notificações</v-subheader>
    <v-list>
      <div v-for="(notify, i) in notifications" :key="i">
        <template v-if="i <= 1">
          <v-list-item two-line @click="editCall(notify)">
            <v-list-item-icon>
              <v-icon :color="checkTypeNotify(notify).color" medium>
                {{ checkTypeNotify(notify).icon }}
              </v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>
                Chamado nº: {{ notify ? notify.data.call_id : "" }}
                {{ checkTypeNotify(notify).name }}:
                {{ checkTypeNotify(notify).text }}
              </v-list-item-title>
              <v-list-item-subtitle
                >Criado por:
                {{
                  notify ? notify.data.created_by.name : ""
                }}</v-list-item-subtitle
              >
            </v-list-item-content>
          </v-list-item>
        </template>
      </div>

      <template v-if="notifications.length > 1">
        <NotificationsDialog
          :notifications="notifications"
          @editNotify="editCall($event)"
        />
      </template>
    </v-list>
  </div>
</template>
 
 <script>
import { mapGetters } from "vuex";
import NotificationsMixins from "./mixins/NotificationsMixins";

import NotificationsDialog from "./NotificationsDialog";

export default {
  created() {
    this.$store.dispatch("allNotifications");
  },
  data() {
    return {
      settings: [],
    };
  },
  components: {
    NotificationsDialog,
  },
  mixins: [NotificationsMixins],
  computed: {
    ...mapGetters(["notifications", "callsById"]),
  },
  methods: {
    editCall(notify) {
      this.$store.dispatch("readNotifyCall", notify).then(() => {
        const call = this.callsById(notify.data.call_id);

        if (call) {
          console.log("call existe", call);
          this.$router.replace({
            name: "callsEdit",
            params: { id: call.id },
          });
        } else {
          this.$store.commit("updatetoastErrorNotify", true);
          this.$store.commit("setCallError", notify.data);
          this.$router.replace({ name: "calls" }).catch(() => {});
        }
      });
    },
  },
};
</script>
 
 <style>
</style>