 <template>
  <v-btn
    v-show="active"
    v-scroll="onScroll"
    color="primary"
    fab
    dark
    fixed
    bottom
    right
    @click="toTop"
  >
    <v-icon>mdi-chevron-up</v-icon>
  </v-btn>
</template>
 
 <script>
export default {
  data() {
    return {
      active: false,
      top: null,
    };
  },
  methods: {
    onScroll(e) {
      if (typeof window === "undefined") return;
      this.top = window.pageYOffset || e.target.scrollTop || 0;
      this.active = this.top > 20;
      //   console.log(this.fab)
      //   console.log(this.top)
    },
    toTop() {
      this.$vuetify.goTo(0);
    },
  },
};
</script>
 
 <style>
</style>