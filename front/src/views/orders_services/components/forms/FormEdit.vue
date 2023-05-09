<template>
  <v-form>
    <v-row>
      <v-col>
        <v-alert color="info" :value="true" border="left">
          <span class="white--text">
            Criado por
            {{
              created_by
                ? `${created_by.name} - ${formatDate(callLocal.created_at)}`
                : ""
            }}
          </span>
        </v-alert>
      </v-col>
    </v-row>
    <v-row>
      <v-col sm="6" md="4" lg="4">
        <validation-provider rules="required" v-slot="{ errors }">
          <v-text-field
            label="Nome"
            v-model="callLocal.name"
            :error-messages="errors[0]"
            readonly
            @input="$emit('call', callLocal)"
          />
        </validation-provider>
      </v-col>

      <v-col sm="6" md="4" lg="4">
        <validation-provider rules="required" v-slot="{ errors, valid }">
          <v-select
            :items="prioritys"
            v-model="callLocal.priority"
            label="Prioridade"
            :error-messages="errors[0]"
            :success="valid"
            readonly
            @input="$emit('call', callLocal)"
          ></v-select>
        </validation-provider>
      </v-col>

      <v-col sm="6" md="4" lg="2">
        <!-- LEMBRETE -> can: admin|solucionador|direcionador -->
        <validation-provider rules="required" v-slot="{ errors }">
          <v-select
            class="text-uppercase"
            :items="status"
            v-model.lazy="callLocal.statu"
            :disabled="!isAdmin && !isSolver"
            :readonly="isConclued"
            label="Status"
            :error-messages="errors[0]"
            @input="$emit('call', callLocal)"
          ></v-select>
        </validation-provider>
      </v-col>

      <v-col sm="6" md="4" lg="2">
        <validation-provider rules v-slot="{ errors }">
          <v-autocomplete
            :items="solvers"
            v-model="solverLocal"
            @input="updateSolver(solverLocal)"
            item-text="name"
            item-value="id"
            label="Técnico"
            :readonly="!isAdmin"
            :disabled="callLocal.statu === 'concluído'"
            :loading="loading || loadingSolver"
            :error-messages="errors[0]"
            :clearable="isAdmin"
          ></v-autocomplete>
        </validation-provider>
      </v-col>
      <!-- </v-row> -->

      <!-- <v-row> -->
      <v-col sm="6" md="4" lg="4">
        <validation-provider rules="required" v-slot="{ errors, valid }">
          <v-text-field
            label="Origem"
            :value="created_by.profile.school"
            :error-messages="errors[0]"
            :success="valid"
            readonly
            @input="$emit('call', callLocal)"
          />
        </validation-provider>
      </v-col>

      <v-col sm="6" md="4" lg="4">
        <validation-provider rules="required" v-slot="{ errors, valid }">
          <v-text-field
            label="Destino"
            v-model="callLocal.destiny"
            :error-messages="errors[0]"
            :success="valid"
            readonly
            @input="$emit('call', callLocal)"
          />
        </validation-provider>
      </v-col>
      <v-col sm="6" md="6" lg="2">
        <validation-provider rules="required" v-slot="{ errors }">
          <v-select
            :items="initials"
            v-model="callLocal.initials"
            class="text-uppercase"
            label="Sigla"
            :error-messages="errors[0]"
            readonly
            @input="$emit('call', callLocal)"
          ></v-select>
        </validation-provider>
      </v-col>
      <v-col sm="6" md="6" lg="2">
        <validation-provider
          name="assunto"
          rules="required"
          v-slot="{ errors, valid }"
        >
          <v-text-field
            label="Prazo contagem em dias"
            type="number"
            v-model="callLocal.term"
            :error-messages="errors[0]"
            :success="valid"
            readonly
            @input="$emit('call', callLocal)"
          />
        </validation-provider>
      </v-col>
    </v-row>

    <v-row>
      <v-col>
        <validation-provider
          name="descricao"
          rules="required"
          v-slot="{ errors, valid }"
        >
          <v-textarea
            clearable
            auto-grow
            outlined
            label="Descrição"
            :disabled="callLocal.statu === 'concluído'"
            v-model="callLocal.description"
            :error-messages="errors[0]"
            :success="valid"
            @input="$emit('call', callLocal)"
          />
        </validation-provider>
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
import { ValidationProvider } from "vee-validate";
import localforage from "localforage";
import AccessControllerMixins from "@/mixins/AcessControllerMixins";
import moment from "moment";

export default {
  created() {
    if (this.call.statu === "concluído") {
      this.isConclued = true;
    }
    localforage.getItem("helpDesk").then(value => {
      this.callLocal = this.call;
      this.solverLocal = this.solver;

      this.$store.dispatch("loadServices");
      this.loadingSolver = true;

      this.loadingSolver = false;
      return (this.auth = value.login.auth);
    });
  },
  props: ["call", "services", "solver"],
  data() {
    return {
      status: [
        "a iniciar",
        "concluído",
        "andamento",
        "atrasado",
        "cancelado",
        "paralisado"
      ],
      prioritys: ["Urgente", "Alta", "Média", "Baixa"],
      initials:["DTI", "SMZ"],
      //initials:["SMEC", "SMAG", "SMO"],
      service_id: "",
      callLocal: {},
      solverLocal: {},
      auth: {},
      disabled: false,
      loading: false,
      loadingSolver: false,
      isConclued: false
    };
  },
  mixins: [AccessControllerMixins],
  components: { ValidationProvider },
  computed: {
    user() {
      return this.$store.getters.usersById(this.auth.id);
    },
    service() {
      return this.services.find(sv => sv.id == this.service_id) || "";
    },
    solvers() {
      const solvers = this.$store.getters.users.filter(user => {
        const roleSolvers = user.roles.filter(role => {
          return role.name == "solucionador";
        });
        const user_id = roleSolvers.map(solver => {
          return solver.pivot.model_id;
        });

        return user.id == user_id;
      });

      return solvers;
    },
    created_by() {
      return this.$store.getters.usersById(this.call.created_by);
    }
  },
  watch: {
    service() {
      this.callLocal = this.service;
    }
  },
  methods: {
    dispatchSolver(solver) {
      this.loading = true;

      this.$store.dispatch("updateSolverCall", solver).then(() => {
        setTimeout(() => {
          this.loading = false;
        }, 1000);
      });
    },

    updateSolver(user_id) {
      const solver = {
        user_id,
        call_id: this.call.id
      };

      if (!solver.user_id) {
        solver.user_id = null;
        this.callLocal.statu = "a iniciar";
        this.$store.dispatch("updateCall", this.callLocal);
        this.dispatchSolver(solver);
      } else {
        this.callLocal.statu = "andamento";
        this.$store.dispatch("updateCall", this.callLocal);
        this.dispatchSolver(solver);
      }
    },

    formatDate(value) {
      moment.locale("pt-br");
      return moment(value).format("dddd L");
    }
  }
};
</script>

<style></style>
