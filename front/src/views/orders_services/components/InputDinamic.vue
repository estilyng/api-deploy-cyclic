<template>
  <div>
    <div v-for="(item, i) in respsLocal" :key="i">
      <v-row class="d-flex align-center justify-space-between">
        <v-col cols="12">
          <ValidationObserver v-slot="{ invalid }">
            <validation-provider rules="required" v-slot="{ errors }">
              <v-text-field
                :label="
                  item.created_by
                    ? `Resposta de ${userCreated_by(item.created_by).name}`
                    : 'Resposta'
                "
                :readonly="
                  auth.id !== userCreated_by(item.created_by).id || item.posted
                "
                v-model="item.text"
                :error-messages="errors[0]"
                textarea
                :clearable="!item.posted"
                counter="100"
              >
                <template v-slot:append-outer>
                  <v-btn
                    v-if="!item.posted"
                    icon
                    color="red"
                    @click.prevent="deleteInput(item.id)"
                  >
                    <v-icon>mdi-delete</v-icon>
                  </v-btn>

                  <v-btn
                    v-if="item.posted"
                    icon
                    color="teal"
                    :loading="item.loading"
                  >
                    <v-icon>mdi-check</v-icon>
                  </v-btn>
                  <v-btn
                    v-else
                    icon
                    color="teal"
                    @click.prevent="sendResponse(item)"
                    :loading="item.loading"
                    :disabled="invalid"
                  >
                    <v-icon>mdi-send</v-icon>
                  </v-btn>
                </template>
              </v-text-field>
            </validation-provider>
          </ValidationObserver>

          <v-rating
            v-if="item.posted"
            :readonly="auth.id == userCreated_by(item.created_by).id"
            v-model="item.rating"
            @input="updateResponse({ id: item.id, rating: item.rating })"
            full-icon="mdi-thumb-up-outline"
            :color="item.rating == 5 ? 'teal' : 'orange'"
            background-color="orange lighten-3"
            half-increments
            hover
            clearable
            medium
          ></v-rating>
        </v-col>
      </v-row>
    </div>

    <a
      @click.prevent="addInput(lastResonseReact ? lastResonseReact.id + 1 : 0)"
      v-show="call_statu !== 'concluído'"
      >Responder</a
    >
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from "vee-validate";
import localforage from "localforage";
export default {
  created() {
    localforage.getItem("helpDesk").then((item) => {
      this.auth = item.login.auth;
      this.respsLocal = this.responses ? this.responses : [];
      // to convert number
      this.respsLocal.forEach((r) => {
        r.rating = Math.trunc(r.rating);
      });
    });
  },
  // responses
  props: {
    responses: { type: [Array, Object], required: true },
    call_id: { type: Number, required: true },
    call_statu: { type: String, required: false },
  },
  data() {
    return {
      respsLocal: [],
      auth: {},
      loading: false,
    };
  },

  components: {
    ValidationProvider,
    ValidationObserver,
  },
  computed: {
    lastResonseReact() {
      return this.respsLocal[this.respsLocal.length - 1];
    },
  },
  methods: {
    addInput(id) {
      const reponse = {
        id,
        text: "",
        rating: 0,
        created_by: this.auth.id,
        loading: false,
      };
      return this.respsLocal.push(reponse);
    },

    deleteInput(index) {
      const authorized = this.auth.roles.filter((r) => {
        return r.name == "administrador" || r.name == "direcionador";
      });
      if (authorized) {
        const id = this.respsLocal.findIndex((item) => item.id === index);
        return this.respsLocal.splice(id, 1);
      }
      return;
    },

    sendResponse(response) {
      response.loading = true;
      this.$store
        .dispatch("storeResponse", this.prepareData(response))
        .then((data) => {
          response.loading = false;
          this.deleteInput(data.id);
          this.respsLocal.push(data);
        })
        .catch(() => (response.loading = false));
    },

    updateResponse(response) {
      console.log("updated response", response);
      this.$store.dispatch("updateResponse", response);
    },

    userCreated_by(created_by) {
      const user = this.$store.getters.usersById(created_by);
      if (user) {
        return user;
      }
      return "";
    },

    prepareData(value) {
      const newResponse = {
        text: value.text,
        rating: value.rating,
        posted: true,
        call_id: this.call_id,
        created_by: value.created_by,
      };
      return newResponse;
    },
  },
};
</script>

<style>
</style>