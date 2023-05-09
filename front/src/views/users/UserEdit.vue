 <template>
  <div>
    <card-default color="light-blue">
      <template v-slot:card-icon>
        <v-icon x-large>mdi-account</v-icon>
      </template>

      <template v-slot:card-title>{{ user ? user.name : "" }}</template>

      <template v-slot:card-title-center>Editar Usuário</template>

      <template v-slot:card-btn-back>
        <v-btn icon color="white">
          <router-link tag="a" :to="{ name: 'users' }">
            <v-icon color="white" x-large>mdi-arrow-left</v-icon>
          </router-link>
        </v-btn>
      </template>

      <template v-slot:card-body>
        <AlertMsg v-show="msg.errors !== null" :msg="msg" />

        <form-edit
          :id="id"
          :loading="loading"
          @submitUpdate="submitUpdate"
          @deleteUser="deleteUser($event)"
        />
      </template>
    </card-default>
  </div>
</template>
 
 <script>
import CardDefault from "@/components/Card";
import FormEdit from "./components/forms/FormEdit";
import AlertMsg from "@/components/AlertMsg";

export default {
  props: ["id"],
  data() {
    return {
      loading: false,
      msg: {
        type: "error",
        color: "error",
        errors: null
      },
    };
  },
  components: {
    FormEdit,
    CardDefault,
    AlertMsg,
  },
  mixins: [],
  computed: {
    user() {
      return this.$store.getters.usersById(this.id);
    },
  },
  methods: {
    async submitUpdate(event) {
      this.loading = true;
      try {
        await this.$store.dispatch("updateUser", event);
        this.$toast.success("Usuário atualizado com sucesso!");
      } catch (error) {
        await this.$store.dispatch("getAuth");
        this.$toast.error("O servidor detectou algum erro...");
        this.$set(this.msg, "errors", error.response.data.errors);
        // this.msg.errors = error.response.data.errors;
      } finally {
        this.loading = false;
      }
    },

    deleteUser(event) {
      console.log("delete user", event);
    },
  },
};
</script>
 
