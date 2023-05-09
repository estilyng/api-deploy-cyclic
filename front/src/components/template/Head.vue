<template>
  <v-app-bar class="app-bar-color" elevation="400" app>
    <v-app-bar-nav-icon
      @click.stop="activeSideBar()"
      color="white"
    ></v-app-bar-nav-icon>

    <v-spacer />
    <v-toolbar-items class="ml-10">
      <v-divider inset vertical light color="white" />

      <v-tooltip bottom>
        <template v-slot:activator="{ on }">
          <v-btn
            text
            to="/home"
            v-on="on"
            class="white--text font-weight-light"
          >
            <v-icon>mdi-home-city-outline</v-icon>
          </v-btn>
        </template>
        <span>Início</span>
      </v-tooltip>

      <v-divider inset vertical light color="white" />

      <v-tooltip bottom>
        <template v-slot:activator="{ on }">
          <v-btn
            text
            :to="{ name: 'calls' }"
            v-on="on"
            class="white--text font-weight-light"
          >
            <v-icon>mdi-face-agent</v-icon>
          </v-btn>
        </template>
        <span>Chamados</span>
      </v-tooltip>

      <v-divider inset vertical light color="white" />

      <v-tooltip bottom v-if="isAdmin || isSolver">
        <template v-slot:activator="{ on }">
          <v-btn
            text
            icon
            v-on="on"
            to="/configure"
            class="white--text font-weight-light"
          >
            <v-icon>mdi-cog-outline</v-icon>
          </v-btn>
        </template>
        <span>Configurações</span>
      </v-tooltip>
      <v-divider inset vertical light color="white" />
    </v-toolbar-items>

    <!-- perfil name -->
    <v-spacer />
    <!-- class="ml-12" -->
    <v-toolbar-items :class="$vuetify.breakpoint.mobile ? 'ma-0' : 'ml-12'">
      <v-menu offset-y transition="slide-y-transition" bottom>
        <template v-slot:activator="{ on }">
          <v-btn text dark v-on="on">
            <v-badge v-if="notifications" avatar overlap class="mr-4">
              <template v-slot:badge>
                <v-avatar>{{ notifications.length }}</v-avatar>
              </template>

              <v-avatar size="50">
                <template v-if="photo">
                  <img :src="photo" alt="Foto do Perfil" />
                </template>
              </v-avatar>
            </v-badge>

            <v-avatar v-else size="50" class="mr-4">
              <template v-if="photo">
                <img :src="photo" alt="Foto do Perfil" />
              </template>
            </v-avatar>
            <span v-if="!$vuetify.breakpoint.mobile">
              {{ auth ? auth.name : "" }}
            </span>
          </v-btn>
        </template>

        <v-card>
          <v-card-title primary-title>{{ auth ? auth.name : "" }}</v-card-title>
          <v-card-text>
            <span>{{ auth ? auth.email : "" }}</span>
            <br />

            <template v-if="auth && auth.roles">
              <span
                class="text-uppercase"
                v-for="(role, i) in auth.roles"
                :key="i"
              >
                <b>{{ role.name }}</b
                >/
              </span>
            </template>
          </v-card-text>

          <template v-if="notifications">
            <v-divider></v-divider>

            <Notifications />
          </template>

          <v-divider></v-divider>

          <v-list>
            <v-list-item @click="editPerfil()">
              <v-btn text icon color="green" class="pl-4">
                <v-icon>mdi-account</v-icon>Perfil
              </v-btn>
            </v-list-item>
            <v-list-item @click="logout()">
              <v-btn text icon color="red">
                <v-icon>mdi-logout-variant</v-icon>Sair
              </v-btn>
            </v-list-item>
          </v-list>
        </v-card>
      </v-menu>
    </v-toolbar-items>
  </v-app-bar>
</template>

<script>
import localforage from "localforage";
import AcessControllerMixins from "@/mixins/AcessControllerMixins";
import PhotosMixins from "../../views/profile/mixins/PhotosMixins";
import { mapGetters } from "vuex";

import Notifications from "../notifications/Notifications";

export default {
  created() {
    localforage.getItem("helpDesk").then((item) => {
      this.auth = item.login.auth;
      // this.photo = item.login.auth.profile.photo;

      this.downloadPhotoFirebase(this.auth)
        .then(async (url) => {
         
          return (this.photo = url);
        })
        .catch((error) => {
          console.error(error);
          return (this.photo = require("@/assets/images/profile.png"));
        });
    });
  },
  data() {
    return {
      activeBtn: 1,
      drawer: this.$store.state.btnSideBar,
      auth: null,
      photo: null,
    };
  },
  components: {
    Notifications,
  },
  mixins: [AcessControllerMixins, PhotosMixins],
  computed: {
    ...mapGetters({
      notifications: "notifications",
      getAuth: "auth",
    }),
  },
  watch: {
    "getAuth.profile.photo"(newQuestion) {
      if (newQuestion) {
        console.log("mudar foto no header", newQuestion);
        this.downloadPhotoFirebase(this.auth).then((url) => (this.photo = url));
      }
    },
  },
  methods: {
    carregar(value) {
      if (value == "Ver Perfil") {
        this.editPerfil();
      } else {
        this.logout();
      }
    },
    logout() {
      const token = localStorage.getItem("access_token");
      this.$store.dispatch("logout", token).then(() => {
        this.$router.push("/login");
        this.$destroy(this.$data);
        document.location.reload(true);
      });
    },
    editPerfil() {
      this.$router.push({ name: "profile" });
    },
    activeSideBar() {
      this.$store.commit("activeSideBar");
    },
  },
};
</script>

<style>
.app-bar-color {
  background: #29AFCB;
  background: -webkit-linear-gradient(to right,#29AFCB, #154997);
  background: linear-gradient(to right,#29AFCB, #154997);
}
</style>