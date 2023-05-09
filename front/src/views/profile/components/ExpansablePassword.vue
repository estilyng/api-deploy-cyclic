 <template>
  <v-expansion-panels accordion flat hover focusable>
    <v-expansion-panel>
      <v-expansion-panel-header class="headline">Nova Senha</v-expansion-panel-header>
      <v-expansion-panel-content>
        <v-row>
          <v-col cols="6">
            <validation-provider rules="min:8" vid="confirmation" v-slot="{errors}">
              <v-text-field
                label="Nova senha"
                type="password"
                v-model.lazy="auth.password"
                hint="Pelo menos 8 carácteres"
                :error-messages="errors[0]"
                @input="$emit('auth-password', auth)"
                clearable
              ></v-text-field>
            </validation-provider>
          </v-col>
          <v-col cols="6">
            <validation-provider rules="confirmed:confirmation" v-slot="{errors}">
              <v-text-field
                label="Confirme a nova senha"
                type="password"
                v-model.lazy="auth.password_confirmation"
                :error-messages="errors[0]"
                @input="$emit('auth-password', auth)"
                clearable
              ></v-text-field>
            </validation-provider>
          </v-col>
        </v-row>
      </v-expansion-panel-content>
    </v-expansion-panel>
  </v-expansion-panels>
</template>
 
 <script>
import { ValidationProvider } from "vee-validate";

export default {
  data() {
    return {
      auth: {},
    };
  },
  components: {
    ValidationProvider,
  },
};
</script>
 
 <style>
</style>