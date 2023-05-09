 <template>
  <div>
    <v-btn small text @click="dialog = true">
      <v-avatar size="30" color="red">
        <v-img src="@/assets/images/profile_developer.jpg" alt="alt"> </v-img>
      </v-avatar>
    </v-btn>

    <v-dialog v-model="dialog" max-width="700">
      <v-card>
        <v-card-text>
          <div>
            <span>
              Desenvolvido no DTI - Depto. de Tecnologia da Informação 
              da Fundação Municipal de Saúde de Rio Claro / SP  
              por Fabrício Santos.
            </span>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
 
 <script>
export default {
  data() {
    return {
      dialog: false,
    };
  },
};
</script>
 
 <style>
</style>