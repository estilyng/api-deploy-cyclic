<template>
  <CardDefualt color="light-blue">
    <template v-slot:card-icon>
      <v-icon x-large class="mr-2">mdi-account-question</v-icon>
    </template>

    <template v-slot:card-title>Tutoriais</template>

    <template v-slot:card-body>
      <v-card-text>
        <h1 class="mb-2">#Controle de Chamados</h1>
        <ul>
          <li>
            <a href="#">
              <h3 class="headline">#Chamados</h3>
            </a>
            <ul>
              <li>
                <a href="#criar-chamados">
                  <h4 class="headline">#Criar</h4>
                </a>
              </li>
              <li>
                <a href="#deletar-chamados">
                  <h4 class="headline">#Deletar</h4>
                </a>
              </li>
              <li>
                <a href="#responder-chamados">
                  <h4 class="headline">#Responder</h4>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </v-card-text>

      <v-card-text>
        <h2 id="criar-chamados" class="mb-2">#Criar Chamados</h2>
        <TutorCreateCall></TutorCreateCall>
      </v-card-text>
      <v-card-text>
        <h2 id="deletar-chamados" class="mb-2">#Deletar Chamados</h2>
        <TutorDeleteCall></TutorDeleteCall>
      </v-card-text>
      <v-card-text>
        <h2 id="responder-chamados" class="mb-2">#Responder Chamados 
          (Em breve)</h2>
        <TutorResponseCall></TutorResponseCall>
      </v-card-text>

      <v-footer>
        <About></About>
      </v-footer>
    </template>
  </CardDefualt>
</template>

<script>
import CardDefualt from "@/components/Card";
import About from "./components/About";
import TutorCreateCall from "./components/TutorCreateCall";
import TutorDeleteCall from "./components/TutorDeleteCall";
import TutorResponseCall from "./components/TutorResponseCall";

export default {
  components: {
    CardDefualt,
    About,
    TutorCreateCall,
    TutorDeleteCall,
    TutorResponseCall,
  },
};
</script>

<style scoped>
li {
  list-style-type: none;
}

a:link {
  color: black;
}

a:visited {
  color: black;
}

a:hover {
  color: #615a5a;
}

a:active {
  color: blue;
}

h1,
h2 {
  color: black;
}
</style>