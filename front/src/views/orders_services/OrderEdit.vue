<template>
  <div>
    <card-default color="primary">
      <template v-slot:card-icon>
        <v-icon x-large class="mr-2">mdi-face-agent</v-icon>
      </template>

      <template v-slot:card-title>
        Nº {{ call ? call.id : "" }} - {{ call ? call.name : "" }}
      </template>

      <template v-slot:card-title-center>Detalhes do Chamado</template>

      <template v-slot:card-btn-back>
        <v-btn icon color="white" v-if="solver" @click="backRouter()">
          <v-icon color="white" x-large>mdi-arrow-left</v-icon>
        </v-btn>

        <v-btn icon color="white" v-else>
          <router-link tag="a" :to="{ name: 'calls' }">
            <v-icon color="white" x-large>mdi-arrow-left</v-icon>
          </router-link>
        </v-btn>
      </template>

      <template v-slot:card-body>
        <template v-if="!newCall">
          <v-skeleton-loader
            v-for="(item, i) in 3"
            :key="i"
            :loading="true"
            class="mx-auto"
            type="article"
            tile
          ></v-skeleton-loader>
        </template>

        <template v-else>
          <form-edit
            @call="getInputs($event)"
            :call="call"
            :solver="solver_data"
            :services="services"
          />

          <image-upload :call_id="call.id" :call_statu="call.statu" />
          <v-divider class="mt-4"></v-divider>

          <v-row v-if="images" justify="center">
            <v-carousel show-arrows-on-hover>
              <v-carousel-item
                v-for="(item, i) in images"
                :key="i"
                :src="baseURL + item.path"
                reverse-transition="fade-transition"
                transition="fade-transition"
                :append="true"
                :href="baseURL + item.path"
                target="_blanck"
              ></v-carousel-item>
            </v-carousel>
          </v-row>

          <v-divider class="mt-4"></v-divider>
          <v-row justify="center">
            <expansion-responses>
              <InputDinamic
                :responses="responses"
                :call_id="call.id"
                :call_statu="call.statu"
              />
            </expansion-responses>
          </v-row>

          <v-divider class="mb-4"></v-divider>
          <v-row>
            <v-col cols="6">
              <dialog-delete-card
                :call="call"
                @deleteCall="deleteCall"
              ></dialog-delete-card>
            </v-col>
            <v-col cols="6">
              <v-btn
                block
                color="success"
                @click="updateCall()"
                :loading="loading"
                >Salvar</v-btn
              >
            </v-col>
          </v-row>
        </template>
      </template>
    </card-default>
  </div>
</template>

<script>
import CardDefault from "@/components/Card";
import FormEdit from "./components/forms/FormEdit";
import imageUpload from "./components/ImagesUploads";
import InputDinamic from "./components/InputDinamic";
import ExpansionResponses from "./components/expansion/ExpansionResponses";
import DialogDeleteCard from "./components/dialogs/DialogDeleteCard";

import GlobalMixins from "@/mixins/globalMixins";

export default {
  async mounted() {
    const images = await this.$store.dispatch("loadImagesCall", this.id);
    const responses = await this.$store.dispatch("loadResponses", this.id);
    const solver = await this.$store.dispatch("loadSolver", this.id);

    this.solver_data = solver;
    this.images = images || [];
    this.responses = responses || "";

    if (!this.call) {
      await this.$store.dispatch("loadCalls", this.id);
      this.newCall = this.call;
    } else {
      this.newCall = this.call;
    }
  },
  props: {
    id: { type: [Number, String], required: true },
    solver: { type: Object, required: false }
  },
  data() {
    return {
      newCall: null,
      solver_data: {},
      images: [],
      //baseURL: "http://localhost:8000/storage/",
      baseURL: "http://131.255.233.6:8008/storage/",
      responses: null,
      loading: false
    };
  },
  mixins: [GlobalMixins],
  components: {
    CardDefault,
    FormEdit,
    imageUpload,
    InputDinamic,
    ExpansionResponses,
    DialogDeleteCard
  },
  // watch: {
  //   "call.id"(lastQuestion, newQuestion) {
  //     // add newCall and refresh page for reload datas
  //     if (newQuestion.id !== lastQuestion) {
  //       this.newCall = this.call;
  //       this.$router.go();
  //     }
  //   }
  // },
  computed: {
    call() {
      return this.$store.getters.callsById(this.id);
    },
    services() {
      return this.$store.getters.services;
    }
  },
  methods: {
    getInputs(event) {
      this.newCall = event;
    },
    async updateCall() {
      this.loading = true;
      try {
        await this.$store.dispatch("updateCall", this.newCall);
        this.$toast.success("Chamado atualizado com sucesso!");
      } catch (error) {
        this.$toast.error("O servidor detectou algum erro...");
        this.getMsgError(error);
      } finally {
        this.loading = false;
      }
    },
    deleteCall() {
      this.$store
        .dispatch("deleteCall", this.id)
        .then(() => {
          return this.$router.replace("/calls");
        })
        .catch(errors => {
          this.getMsgError(errors);
        });
    },

    backRouter() {
      this.$router.push({
        name: "callsSolver",
        params: { id: this.solver.id, solver: this.solver }
      });
    }
  }
};
</script>

<style></style>
