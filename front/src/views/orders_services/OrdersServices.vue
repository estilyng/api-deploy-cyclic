<template>
  <v-data-iterator
    :items="calls"
    :items-per-page.sync="itemsPerPage"
    :page="page"
    :search="search"
    no-data-text="Nenhum registro encontrado"
    hide-default-footer
  >
    <template v-slot:header class="d-flex">
      <v-text-field
        v-model="search"
        clearable
        flat
        solo-inverted
        hide-details
        label="Buscar"
      ></v-text-field>

      <dialog-add />
    </template>

    <template v-slot:default="props">
      <Paginations :calls="calls"></Paginations>
      <v-row>
        <v-col v-for="(item, i) in props.items" :key="i" cols="12">
          <v-progress-circular
            color="purple"
            v-if="loading"
            indeterminate
          ></v-progress-circular>

          <OrderService v-else :call="item" :user_id="item.created_by" />
        </v-col>
      </v-row>
    </template>

    <template v-slot:footer>
      <Paginations :calls="calls"></Paginations>
    </template>
  </v-data-iterator>
</template>

<script>
import OrderService from "./components/OrderService";
import DialogAdd from "./components/dialogs/DialogAdd";
import Paginations from "./components/Paginations";

export default {
  created() {
    this.$store.dispatch("loadCalls").then(() => {
      this.$store.dispatch("allNotifications");
      // this.$store.dispatch("loadUsers");
      this.loading = false;
      this.concatItems();
    });
  },
  data() {
    return {
      loading: true,
    };
  },
  components: { OrderService, DialogAdd, Paginations },
  computed: {
    calls() {
      return this.$store.getters.calls;
    },

    users() {
      return this.$store.getters.users;
    },

    itemsPerPage: {
      get() {
        return this.$store.getters.getItemsPerPage;
      },
      set(value) {
        this.$store.commit("updateItemPerPage", value);
      },
    },
    page: {
      get() {
        return this.$store.getters.getPage;
      },
      set(value) {
        return this.$store.commit("updatePage", value);
      },
    },
    search: {
      get() {
        return this.$store.getters.searchCalls;
      },
      set(value) {
        return this.$store.commit("updateSearchCalls", value);
      },
    },
  },
  methods: {
    concatItems() {
      this.calls.forEach((call) => {
        call.from = this.users.find(
          (user) => user.id === call.created_by
        ).profile.school;
      });
    },
  },
};
</script>

<style>
</style>