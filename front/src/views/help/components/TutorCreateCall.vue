<template>
  <div>
 
   <p>Criar chamados é muito simples <!--<img height="20" width="20" src="@/assets/emojis/piscadela.png" app />.--> listamos abaixo um passo a passo de como fazer:</p>
   <p>
     <ol>
       <li>
         Clique em Chamados (botão <v-icon>mdi-face-agent</v-icon>)
       </li>
       <li>Clique em 
         <v-btn color="success" small><v-icon>mdi-plus</v-icon></v-btn>
       </li>
       <li>Escolha o serviço equivalente a sua necessidade</li>
       <li>Após escolher, o sistema irar automaticamente preencher todos os campos, permitindo editar apenas o campo "descrição".
         <ul>
           <li>Obs: A edição deste campo é permitida para o caso de você usuário, querer acrescentar mais informações pertinentes ao serviço
             que está solicitando.
           </li>
         </ul>
       </li>
       <li>Clique em  <v-btn color="primary" small>Salvar</v-btn></li>
       <li>Você será encaminhado ao próximo passo que é inserir fotos/prints do problema.
         <ul>
           <li>Obs: esta etapa é facultativa. Caso não queira inserir fotos/prints, basta clicar fora da janela e seu chamado estará lá, criado e com status 
             <v-chip small color="#B2DFDB">A INICIAR</v-chip>
           </li>
         </ul>
       </li>
       <li>
         Clique no campo "Anexar Imagens", escolha o(s) print(s)/foto(s) e clique em <v-btn color="primary" small>Carregar</v-btn> 
       </li>
       <li>
         Pronto! Agora você será encaminhado para página de "Editar Chamado" onde poderá acrescentar ou corrigir qualquer dado.
       </li>
     </ol>
   </p>
 <!-- Fazer video demo antes do deploy!
   <p>
     Viu só como é simples!? Não? 8 etapas é muito? Ficou difícil ? <img src="@/assets/emojis/confuso.png" alt="emoji confuso" height="20" width="20"> 
   </p>
   <p>
     Sem problemas!  preparamos um pequeno vídeo.
     Esperamos que assim fique mais claro pra você.<img src="@/assets/emojis/feliz.png" alt="emoji feliz" height="20" width="20">
   </p>
     <v-img src="@/assets/gifs/criar_servico.gif"></v-img>-->
  </div>
 </template>
  
  <script>
 export default {
   name: 'TutorCreateCall'
 };
 </script>
  
  <style>
 </style>