<template>
  <v-card class="mt-10 mx-auto">
    <v-sheet
      :color="color"
      class="v-sheet--offset mx-auto"
      elevation="12"
      max-width="calc(100% - 32px)"
      height="90"
      dark
    >
      <span class="headline d-flex justify-space-around align-center pa-3">
        <slot name="card-icon"></slot>
        <slot name="card-title"></slot>

        <v-spacer></v-spacer>

        <slot name="card-title-center"></slot>

        <v-spacer></v-spacer>

        <slot name="card-btn-back"></slot>
      </span>
    </v-sheet>

    <v-card-title class="pt-0">
      <slot name="card-header">
        <v-row class="d-flex align-center">
          <v-col cols="7">
            <slot name="card-header-list-btnPlus"></slot>
          </v-col>

          <v-col cols="5">
            <slot name="card-header-list-fieldSearch"></slot>
          </v-col>
        </v-row>
      </slot>
    </v-card-title>

    <v-card-text class="pt-0">
      <slot name="card-body"></slot>
    </v-card-text>
  </v-card>
</template>
 
 <script>
export default {
  props: ["color"],
};
</script>
 
 <style scoped>
.v-sheet--offset {
  top: -24px;
  position: relative;
}
</style>