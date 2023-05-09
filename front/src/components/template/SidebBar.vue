<template>
  <v-navigation-drawer v-model="drawer" height="100%" absolute temporary left app>
    <v-list nav dense>
      <v-list-item-group>
        <router-link class="remove-link" to="/home">
          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-home-city-outline</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>INÍCIO</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </router-link>

        <router-link class="remove-link" :to="{ name: 'calls' }">
          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-face-agent</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>CHAMADOS</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </router-link>

        <router-link
          class="remove-link"
          :to="{ name: 'users' }"
          v-if="isAdmin || isSolver"
        >
          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-account</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>USUÁRIOS</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </router-link>
        
        <!-- Em breve
        <router-link
          class="remove-link"
         :to="{ name: 'chat' }"
          v-if="isAdmin || isSolver"
        >
          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-chat</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>BATE-PAPO</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </router-link>-->
        
        <router-link
          class="remove-link"
          to="/configure"
          v-if="isAdmin || isSolver"
        >
          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-cog-outline</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>CONFIGURAÇÕES</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </router-link>

        <router-link class="remove-link" :to="{ name: 'helpers' }">
          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-account-question</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>AJUDA</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </router-link>
      </v-list-item-group>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import AcessControllerMixins from "@/mixins/AcessControllerMixins";

export default {
  computed: {
    drawer: {
      get() {
        return this.$store.state.btnSideBar;
      },
      set(value) {
        this.$store.commit("updateBtnSideBar", value);
      },
    },
  },
  mixins: [AcessControllerMixins],
};
</script>

<style>
.remove-link {
  text-decoration: none;
}
</style>