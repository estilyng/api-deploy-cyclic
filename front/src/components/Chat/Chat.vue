 <template>
  <v-card min-height="450px" elevation="2">
   

    <!-- <v-card-text class="pa-1"> -->
        <slot name="top-bar"></slot>
        <slot name="sidebar"></slot>
    <v-row>
      <!-- <v-col sm="6" md="3" class="mr-md-0 pr-md-0"> -->
      <!-- </v-col> -->

      <!-- <v-col sm="10" md="9" class="ml-md-0 pl-md-0"> -->
        <!-- messages -->
        <v-col>
          <slot name="content"></slot>
        </v-col>
          
        <!-- send -->
      <!-- </v-col> -->
    </v-row>
    <!-- </v-card-text> -->
    <v-card-actions class="pa-0">
      <ChatFooter />
    </v-card-actions>
  </v-card>
</template>
 
 <script>
import ChatFooter from "./ChatFooter";

export default {
  components: { ChatFooter },
  methods: {
    send(event) {
      this.messages.push(event);
    },
   
  },
 
};
</script>
 
 <style>
</style>