// import Vue from 'vue'

import firebase from 'firebase/app';

// Vue.use(firebase) - gerenciamento de imagem de perfil

import 'firebase/firebase-storage'

let firebaseConfig = {
    apiKey: "AIzaSyBgYFA3-RkeT0GriHrb_ULzeQyqdR-IV1E",
    authDomain: "helpdesk-pmbv.firebaseapp.com",
    databaseURL: "https://helpdesk-pmbv.firebaseio.com",
    projectId: "helpDesk-pmbv",
    storageBucket: "helpdesk-pmbv.appspot.com",
    messagingSenderId: "747401243345",
    appId: "1:747401243345:web:afddc6c4972be53f3d73f0",
    measurementId: "G-071HF3L5TF"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
// firebase.analytics();