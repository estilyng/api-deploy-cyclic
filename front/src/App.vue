<template>
  <v-app>
    <v-main v-if="$route.name == 'login'" class="d-flex align-center">
      <v-container fluid class="d-flex justify-center">
        <router-view />
      </v-container>
    </v-main>
    <layout-default v-else>
      <OnScroll></OnScroll>
      <ChatContainer v-if="$route.name !== 'chat'" />
      <router-view />
    </layout-default>
  </v-app>
</template>

<script>
import LayoutDefault from "./components/template/LayoutDefault";
import OnScroll from "./components/OnScroll";
import ChatContainer from "./components/Chat/ChatContainer";

export default {
  // mounted() {
  //   this.$store.dispatch("load_chat_user");
  //   this.$store.dispatch("loadMessages");
  // },
  components: { LayoutDefault, OnScroll, ChatContainer },
};
</script>

<style lang="css">
#app {
  background: #f6f4f4;
 /* background: -webkit-linear-gradient(to right, #e9e4f0, #e6e6e6);
  background: linear-gradient(to right, #e9e4f0, #e6e6e6);*/
}

a {
  text-decoration: none;
}
</style>
