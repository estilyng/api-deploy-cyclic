<template>
  <div>
    <Head />
    <SidebBar />
    <v-main>
      <v-container class="mb-2">
        <!-- ToastErrorNotify será invocado sempre que um novo call ñ existir quando clicar em notificação -->
        <ToastErrorNotify />
        <slot />
      </v-container>
    </v-main>
    <Footer />
  </div>
</template>

<script>
import Head from "./Head";
import Footer from "./Footer";
import SidebBar from "./SidebBar";
import ToastErrorNotify from "../notifications/ToastErrorNotify";

export default {
  components: { SidebBar, Head, Footer, ToastErrorNotify },
};
</script>

<style>
</style>