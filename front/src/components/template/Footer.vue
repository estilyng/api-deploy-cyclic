<template>
  <v-footer class="footer-color" height="50%" absolute app>
    <v-row>
      <v-col class="text-center">
        <span class="white--text"
        >&copy; Fundação Municipal de Saúde de Rio Claro - SP | versão 0.1.0 - Sat Saúde</span
        >
      </v-col>
    </v-row>
  </v-footer>
</template>

<script>
export default {
  async mounted() {
    await this.$store.dispatch("allNotifications");
    await this.$store.dispatch("loadUsers");
    await this.$store.dispatch("loadCalls");
  }
};
</script>

<style>
.footer-color {
  background: #29AFCB; /* fallback for old browsers */
  background: -webkit-linear-gradient(to right,
  #29AFCB,
  #154997
   
); /* Chrome 10-25, Safari 5.1-6 */
  background: linear-gradient(
    to right,
    #29AFCB,
    #154997
  ); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
</style>
