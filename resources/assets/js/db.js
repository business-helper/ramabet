let firebaseConfig = {
    apiKey: "AIzaSyAVjqXxADtGM2ei4vLcgDXbcorR_uR0TpY",
    authDomain: "pwarsaeproject.firebaseapp.com",
    databaseURL: "https://pwarsaeproject.firebaseio.com",
    projectId: "pwarsaeproject",
    storageBucket: "pwarsaeproject.appspot.com",
    messagingSenderId: "1044200575487",
    appId: "1:1044200575487:web:084e4cd7b42bfd1f"
};
// Initialize Firebase
let app = firebase.initializeApp(firebaseConfig);
let mydb = app.database();