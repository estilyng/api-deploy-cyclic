<template>
  <card-default color="light-blue">
    <template v-slot:card-icon>
      <v-icon x-large>mdi-format-list-bulleted</v-icon>
    </template>

    <template v-slot:card-title>Lista de Usuários</template>

    <template v-slot:card-header-list-btnPlus>
      <v-btn large to="users/create" color="success">
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </template>
    <template v-slot:card-header-list-fieldSearch>
      <v-text-field
        clearable
        label="Buscar"
        v-model="search"
        prepend-icon="mdi-magnify"
      ></v-text-field>
    </template>

    <template v-slot:card-body>
     
     <AlertMsg v-show="msg.errors" :msg="msg" />

      <!-- <v-pagination :length="numberOfPages" v-model="pagination.page " circle></v-pagination> -->

      <v-data-table
        :headers="headers"
        :items="users"
        :loading="loading"
        loading-text="caregando.."
        loader-height="2"
        :search="search"
        :items-per-page="pagination.itemsPerPage"
        :options.sync="pagination"
        :footer-props="{
          itemsPerPageText: 'Linhas por Página',
          itemsPerPageAllText: 'Todos',
          pageText: `${pagination.page} de ${numberOfPages}`,
        }"
      >
        <template v-slot:[`item.roles`]="{ item }">
          <span v-for="role in item.roles" :key="role.id" class="mx-1">
            <v-chip
              :color="colorRoles(role.name)"
              dark
              class="text-uppercase"
              >{{ role.name }}</v-chip
            >
          </span>
        </template>

        <template v-slot:[`item.profile`]="{ item }">
          <v-switch
            v-if="isSolver(item.id)"
            v-model="item.profile.driver"
            color="primary"
            :value="item.profile.driver"
            @change="changeDriver(item.id, item.profile.driver)"
            hide-details
          ></v-switch>

          <span v-else>----</span>
        </template>

        <template v-slot:[`item.actions`]="{ item }">
          <v-btn icon color="primary" :to="`/users/${item.id}/edit`">
            <v-icon>mdi-pencil</v-icon>
          </v-btn>

          <dialog-delete
            :user_id="item.id"
            @ladingTable="loading = $event"
            @msgError="getMsgError($event)"
          ></dialog-delete>
        </template>
      </v-data-table>
    </template>
  </card-default>
</template>

<script>
import CardDefault from "@/components/Card";
import DialogDelete from "./components/dialogs/DialogDeleteUser";
import AlertMsg from "@/components/AlertMsg";

import GlobalMixin from "@/mixins/globalMixins";

export default {
  components: {
    DialogDelete,
    CardDefault,
    AlertMsg
  },
  mixins: [GlobalMixin],
  data() {
    return {
      search: "",
      dialog: false,
      pagination: {
        itemsPerPage: 6,
        page: 1,
      },
      loading: false,
      headers: [
        {
          text: "Nome",
          value: "name",
        },
        {
          text: "E-mail",
          value: "email",
        },
        {
          text: "Funções",
          value: "roles",
        },
        {
          text: "Setor",
          value: "profile.school",
        },
        {
          text: "Auto direcionador",
          value: "profile",
          sortable: false,
        },
        {
          text: "Ações",
          value: "actions",
          sortable: false,
        },
      ],
    };
  },
  computed: {
    users() {
      const users = Array.from(this.$store.getters.users);
      return users;
    },
    numberOfPages() {
      return Math.ceil(this.users.length / this.pagination.itemsPerPage);
    },
  },
  methods: {
    colorRoles(role) {
      if (role == "administrador") return "purple darken-2";
      if (role == "direcionador") return "blue darken-1";
      if (role == "operador") return "cyan darken-1";
      if (role == "solucionador") return "teal";
    },

    isSolver(id) {
      const user = this.users.find((user) => {
        return user.id == id;
      });

      const solver = user.roles.filter((role) => role.name == "solucionador");

      if (solver.length > 0) {
        return true;
      } else return false;
    },

    async changeDriver(user_id, driver) {
      const user = {
        id: user_id,
        driver,
      };

      await this.$store.dispatch("updateUserDriver", user);
    },
  },
};
</script>

<style>
</style>