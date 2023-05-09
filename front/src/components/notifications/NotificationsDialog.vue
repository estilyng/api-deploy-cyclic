 <template>
  <div>
    <v-list-item @click="() => {}">
      <v-list-item-icon>
        <v-icon color="blue">mdi-dots-horizontal-circle</v-icon>
      </v-list-item-icon>
      <v-list-item-content>
        <v-list-item-title>
          <a @click.stop="dialog = true">Ver mais...</a>
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>

    <v-dialog v-model="dialog" max-width="1000">
      <v-card>
        <v-card-title class="d-flex justify-center headline"
          >Notificações</v-card-title
        >
        <v-card-text>
          <v-text-field
            label="Buscar"
            v-model="search"
            prepend-icon="mdi-magnify"
            clearable
          ></v-text-field>

          <v-list v-for="(notify, i) in filteredNotifications" :key="i">
            <v-list-item two-line @click="edit(notify)">
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
          </v-list>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn text color="error" @click.stop="dialog = false">Sair</v-btn>

          <v-btn text color="success" @click="markReadAll()">
            <v-icon>mdi-check-box-multiple-outline</v-icon>
            Marcar todas como lidas
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
 
 <script>
import NotificationsMixins from "./mixins/NotificationsMixins";

export default {
  created() {
    console.log("notificacoes modal", this.notifications);
  },
  data() {
    return {
      dialog: false,
      search: null,
    };
  },
  props: ["notifications"],
  mixins: [NotificationsMixins],
  computed: {
    filteredNotifications() {
      return this.notifications.filter((notify) => {
        if (this.search) {
          const call_id = this.search.includes(notify.data.call_id);

          const name = this.search
            .toLowerCase()
            .split(" ")
            .includes(notify.data.call_name);

          const created_by = this.search
            .toLowerCase()
            .split(".")
            .includes(notify.data.created_by.name);

          return call_id || name || created_by;
        } else {
          return this.notifications;
        }
      });
    },
  },
  methods: {
    edit(notify) {
      this.$emit("editNotify", notify);
      this.dialog = false;
    },
    markReadAll() {
      this.$store.dispatch("markReadAll");
    },
  },
};
</script>
 
 <style>
</style>