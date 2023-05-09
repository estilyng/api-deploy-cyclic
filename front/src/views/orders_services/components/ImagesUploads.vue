<template>
  <!-- <v-row class="d-flex align-baseline"> -->
  <!-- <v-col lg="11" class="pa-0"> -->
  <!-- class="row d-flex justify-space-around align-baseline" -->

  <ValidationProvider rules="required">
    <v-file-input
      :disabled="call_statu === 'concluído'"
      accept="image/png, image/jpeg, image/bmp"
      placeholder="Anexar Imagens/Arquivos"
      prepend-icon="mdi-camera"
      v-model="images"
      multiple
      outlined
      show-size
      append-icon="mdi-send"
      @click:append="onUpload"
    >
      <template v-slot:selection="{ text }">
        <v-chip small label color="primary">
          {{ text }}
        </v-chip>
      </template>
    </v-file-input>
  </ValidationProvider>
  <!-- </v-col> -->
  <!-- <v-col lg="1">
      <v-btn
        small
        class="ml-2"
        color="primary"
        @click="onUpload"
        :loading="loading"
        :disabled="invalid"
        >CARREGAR</v-btn
      >
    </v-col> -->
  <!-- </v-row> -->
</template>

<script>
import axios from "axios";
import { ValidationProvider } from "vee-validate";

export default {
  props: {
    call_id: { type: Number, required: false },
    call_statu: { type: String, required: false }
  },
  data() {
    return {
      images: null,
      loading: false
    };
  },
  components: { ValidationProvider },
  methods: {
    prepareFormData() {
      console.log("prepareFormData", this.images);

      if (this.images !== null) {
        let formData = new FormData();

        for (let index = 0; index < this.images.length; index++) {
          let image = this.images[index];
          formData.append("images[" + index + "]", image);
        }
        // console.log(formData);

        return formData;
      } else {
        return;
      }
    },

    caseAddPlusImages() {
      if (this.images !== null && this.call_id) {
        this.loading = true;
        axios
          .post(`images/${this.call_id}`, this.prepareFormData(), {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("access_token")}`,
              "Content-Type": "multipart/form-data"
            }
          })
          .then(() => {
            // this.loading = false;
            // this.$store.dispatch("loadImagesCall", this.call_id).then(items => {
            //   this.images = items != "" ? items : null;
            //   // console.log("images", this.images);
            // });
            this.$toast.success("Upload de imagem realizado com sucesso!");
            this.images = null;
          })
          .catch(e => {
            console.log(e.response.data);
          });
      }
    },

    onUpload() {
      // this.$emit("loading", { loading: true, dialog: false });

      if (this.call_id) {
        this.caseAddPlusImages();
      } else if (this.images !== null) {
        axios
          .post("images", this.prepareFormData(), {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("access_token")}`,
              "Content-Type": "multipart/form-data"
            }
          })
          .then(() => {
            // this.$emit("loading", { loading: false, dialog: false });

            // console.log("response route store image", resp.data);
            // this.$router
            //   .push({
            //     name: "callsEdit",
            //     params: { id: resp.data.id }
            //   })
            //   .catch(() => {});
            this.$toast.success("Upload de imagem realizado com sucesso!");
            this.images = null;
          })
          .catch(e => {
            console.log(e.response.data);
          });
      } else {
        return;
      }
    }
  }
};
</script>

<style></style>
