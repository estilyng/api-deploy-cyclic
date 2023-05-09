<template>
  <div>
    <p>
      Informamos que este sistema não possui lixeira, ou seja, os chamados excluídos, serão deletados permanentemente.
      Desta forma, caso execute acidentalmente, você precisará novamente abrir um novo chamado onde o sistema irá
      recalcular o prazo para solução.
    </p>
    <p>Existem duas formas:</p>

    <p>1ª Forma:</p>

    <ol>
      <li>
        Clique em Chamados (botão
        <v-icon>mdi-face-agent</v-icon>)
      </li>
      <li>
        Escolha o chamado que deseja deletar e clique em
        <v-btn icon color="red" small>
          <v-icon medium>mdi-delete</v-icon>
        </v-btn>
      </li>
      <li>Aparecerá uma janela de confirmação de exclusão</li>
      <li>
        Clique em
        <v-btn color="red darken-1" text>Excluir</v-btn>
      </li>
    </ol>

    <p>2ª Forma:</p>

    <ol>
      <li>
        Novamente em Chamados
        (
        <v-icon>mdi-face-agent</v-icon>)
      </li>
      <li>
        Escolha o chamado desejado e clique em detalhes (
        <v-btn icon color="primary">
          <v-icon>mdi-card-account-details</v-icon>
        </v-btn>)
      </li>
      <li>
        Role a página até encontrar o botão
        <v-btn small color="red" class="white--text">Excluir</v-btn>
      </li>
      <li>Após clicar, aparecerá uma janela de confirmação de exclusão</li>
      <li>
        Clique em
        <v-btn color="red darken-1" text>Excluir</v-btn>
      </li>
      <li>
        Você será redirecionado para lista de chamados (
        <v-icon>mdi-face-agent</v-icon>)
      </li>
    </ol>

    <p class="mt-2">FIM. Agora sua ordem de serviço/chamado foi excluída permanentemente. <!--<img src="@/assets/emojis/feliz.png" alt="emoji feliz" height="20" width="20">--></p>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>