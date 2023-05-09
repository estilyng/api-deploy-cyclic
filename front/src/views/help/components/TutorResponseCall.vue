<template>
  <div>
    <p>
      Esta é uma função onde o Operador consegue se comunicar com o usuário Solucionador enviando respostas como forma
      mensagens.
    </p>
    <!--
    <p>
      Para melhor interação entre Operador e Solucionador, adicinamos o recurso de pontuar likes (de 1 a 5) as resposta enviadas e recebidas.
      Este método é útil no quesito motivacional de ambos os lados e torna também mais divertido de fazer.
      <img
        src="@/assets/emojis/feliz_demais.png"
        alt="emoji feliz"
        height="20"
        width="20"
      />
    </p>-->
 
    <ol>
      <li>
        Ainda em Chamados (
        <v-icon>mdi-face-agent</v-icon>)
      </li>
      <li>
        Escolha o chamado desejado e clique em detalhes (
        <v-btn icon color="primary">
          <v-icon>mdi-card-account-details</v-icon>
        </v-btn>)
      </li>
      <li>
        Role até encontrar o nome "
        <b>Respostas</b>".
      </li>
      <li>Clique e ele irá expandir todas as respostas (mensagens) referentes a este chamado</li>
      <li>
        Clique no link
        <a>Responder</a> e aparecerá um novo campo disponível para edição.
      </li>
      <li>
        Escreva sua mensagem e clique em enviar (
        <v-btn icon color="teal">
          <v-icon>mdi-send</v-icon>
        </v-btn>)
        <ul>
          <li>Obs: Este botão só será habilitado após o campo ser preenchido</li>
        </ul>
      </li>
    </ol>

    <p>FIM! sua resposta foi enviada. A partir de agora, o solucionador poderá vê-la</p>
    <!--<p>Observe que apareceram as estrelinhas de pontuação. Apenas o usuário Solucionador poderá pontuar sua resposta, assim vice-versa</p>

    <h3>Pontuar Respostas</h3>
    <p>Passe o mouse por cima das estrelas até a pontuação deseja e clique.</p>
    <p>Preparamos um pequeno playground para você:</p> -->
   
    <!--Aqui codigo rating-->

    
  </div>
</template> 
 
<!--Aqui script rating-->
 
 <style>
</style>