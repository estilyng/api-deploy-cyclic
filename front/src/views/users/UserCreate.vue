 <template>
  <card-default color="light-blue">
    <template v-slot:card-icon>
      <v-icon x-large>mdi-playlist-plus</v-icon>
    </template>

    <template v-slot:card-title>Registrar Usuário</template>

    <template v-slot:card-btn-back>
      <v-btn icon color="white">
        <router-link tag="a" :to="{ name: 'users' }">
          <v-icon color="white" x-large>mdi-arrow-left</v-icon>
        </router-link>
      </v-btn>
    </template>

    <template v-slot:card-body>
      <ToastMsg @closeToast="clearMsg($event)" :msg="msg" />
      <AlertMsg v-if="msg.errors || msg.success" :msg="msg" />

      <form-create :loading="loading" @submit="storeUser($event)" />
    </template>
  </card-default>
</template>
 
 <script>
import FormCreate from "./components/forms/FormCreate";
import CardDefault from "@/components/Card";
import ToastMsg from "../../components/ToastMsg";
import AlertMsg from "../../components/AlertMsg";

import GlobalMixin from "../../mixins/globalMixins";

export default {
  data() {
    return {
      user: {},
      loading: false,
    };
  },
  components: {
    FormCreate,
    CardDefault,
    ToastMsg,
    AlertMsg,
  },
  mixins: [GlobalMixin],
  methods: {
    storeUser(event) {
      this.loading = true;
      this.$store
        .dispatch("storeUser", event)
        .then((user) => {
          this.$router.replace({
            name: "usersEdit",
            params: { id: user.id },
          });
        })
        .catch((error) => {
          this.getMsgError(error);
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>
 
 <style>
</style>