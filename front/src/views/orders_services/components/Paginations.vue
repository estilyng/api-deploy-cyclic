 <template>
  <v-row class="mt-2" align="center">
    <span class="grey--text">Itens por Página</span>
    <v-menu offset-y>
      <template v-slot:activator="{ on }">
        <v-btn dark text color="primary" class="ml-2" v-on="on">
          {{ itemsPerPage }}
          <v-icon>mdi-chevron-down</v-icon>
        </v-btn>
      </template>
      <v-list>
        <v-list-item
          v-for="(number, index) in itemsPerPageArray"
          :key="index"
          @click="updateItemsPerPage(number)"
        >
          <v-list-item-title>{{ number }}</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>

    <v-spacer></v-spacer>

    <span class="mr-4 grey--text"
      >Página {{ page }} de {{ numberOfPages }}</span
    >
    <v-tooltip bottom>
      <template v-slot:activator="{ on }">
        <v-btn
          icon
          dark
          color="blue darken-3"
          class="mr-1"
          @click="page = 1"
          v-on="on"
        >
          <v-icon>mdi-arrow-collapse-left</v-icon>
        </v-btn>
      </template>
      <span>Página 1</span>
    </v-tooltip>
    <v-btn fab dark color="blue darken-3" class="mr-1" @click="formerPage">
      <v-icon>mdi-chevron-left</v-icon>
    </v-btn>
    <v-btn fab dark color="blue darken-3" class="ml-1" @click="nextPage">
      <v-icon>mdi-chevron-right</v-icon>
    </v-btn>

    <v-tooltip bottom>
      <template v-slot:activator="{ on }">
        <v-btn
          icon
          dark
          color="blue darken-3"
          class="mr-1"
          @click="page = numberOfPages"
          v-on="on"
        >
          <v-icon>mdi-arrow-collapse-right</v-icon>
        </v-btn>
      </template>
      <span>Página {{ numberOfPages }}</span>
    </v-tooltip>
  </v-row>
</template>
 
 <script>
export default {
  props: ["calls"],
  data() {
    return {
      itemsPerPageArray: [1, 2, 4, 8, 12],
    };
  },
  computed: {
    numberOfPages() {
      return Math.ceil(this.calls.length / this.itemsPerPage);
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
    nextPage() {
      if (this.page + 1 <= this.numberOfPages) this.page += 1;
    },
    formerPage() {
      if (this.page - 1 >= 1) this.page -= 1;
    },
    updateItemsPerPage(number) {
      this.page = 1;
      this.itemsPerPage = number;
    },
  },
};
</script>
 
 <style>
</style>