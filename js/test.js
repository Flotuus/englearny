$(document).ready(function() {

    let themeTest = document.getElementById("selectTheme");
    let btTheme = document.getElementById("btTheme");
    let btTrad = document.getElementById("btTrad");
    let btEnd = document.getElementById("btEnd");
    let btBegin = document.getElementById("btBegin");
    let labelTheme = document.getElementById("labelTheme");
    let question = document.getElementById("question");
    let reponse = document.getElementById("reponse");
    let card = document.getElementById("card");
    let mots = [];
    let motsTraduits = [];
    let reponseUtilisateur = [];
    let score = 0;
    let questionActuelle;
    question.style.display = "none";
    reponse.style.display = "none";
    btTrad.style.display = "none";
    btEnd.style.display = "none";
    btBegin.style.display = "none";
    card.style.display = "none";

    

    function ajaxTests(){
        var request= $.ajax({
            url: "http://serveur1.arras-sio.com/symfony4-4061/englearny/public/api/tests?page=1", 
            method:"GET",
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "application/json; charset=utf-8" );
            }});
        request.done(function( msg ) {

            $.each(msg, function(index,e){
                themeTest.innerHTML += "<option value="+ e.id +" >" + e.libelle + "</option>"            });
        });
        // Fonction qui se lance lorsque l’accès au web service provoque une erreur
        request.fail(function( jqXHR, textStatus ) {
            alert ('erreur sur Tests');
        });
    }

    function ajaxMotById(idMot){
        var request= $.ajax({
            url: "http://serveur1.arras-sio.com"+idMot, 
            method:"GET",
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "application/json; charset=utf-8" );
            }});
        request.done(function( msg ) {
            mots.push(msg.libelle);
            motsTraduits.push(msg.traduction);
           
        });
        // Fonction qui se lance lorsque l’accès au web service provoque une erreur
        request.fail(function( jqXHR, textStatus ) {
            alert ('erreur sur motById');
        });
    }

    function ajaxListeById(idListe){
        var request= $.ajax({
            url: "http://serveur1.arras-sio.com"+idListe, 
            method:"GET",
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "application/json; charset=utf-8" );
            }});
        request.done(function( msg ) {
            
             $.each(msg.mots, function(index,e){
                ajaxMotById(e);
            }); 
        });
        // Fonction qui se lance lorsque l’accès au web service provoque une erreur
        request.fail(function( jqXHR, textStatus ) {
            alert ('erreur sur listeById');
        });
    }

    function ajaxTestById(idTest){
        var request= $.ajax({
            url: "http://serveur1.arras-sio.com/symfony4-4061/englearny/public/api/tests/"+idTest, 
            method:"GET",
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "application/json; charset=utf-8" );
            }});
        request.done(function( msg ) {
            ajaxListeById(msg.liste);
        });
        // Fonction qui se lance lorsque l’accès au web service provoque une erreur
        request.fail(function( jqXHR, textStatus ) {
            alert ('erreur sur testById');
        });
    }

    function verification(prop,rep){
        for(let i = 0; i<prop.length;i++){
            if (prop[i] == rep[i]){
                score += 1;
            }
        }
    }

    btTheme.addEventListener("click", function () {
        if (themeTest.value != 0){
            themeTest.style.display = "none";
            btTheme.style.display = "none";
            labelTheme.style.display = "none";
            ajaxTestById(themeTest.value);
            questionActuelle = 0;
            btBegin.style.display = "block";
            

        }    
    },false);

    btBegin.addEventListener("click", function () {
        question.innerHTML = "Traduire le mot suivant :" + mots[questionActuelle];
        questionActuelle += 1;
        card.style.display = "block";
        question.style.display = "block";
        reponse.style.display = "block";
        btBegin.style.display = "none";
        btTrad.style.display = "block";
    })

    btTrad.addEventListener("click", function () {

        if(questionActuelle < mots.length){
            reponseUtilisateur.push(reponse.value);
            reponse.value = "";
            question.innerHTML = "Traduire le mot suivant :" + mots[questionActuelle];
            questionActuelle += 1;
    
        }else{
            reponseUtilisateur.push(reponse.value);
            verification(reponseUtilisateur,motsTraduits);
            question.innerHTML = "test fini, score :" +  score;
            reponse.style.display = "none";
            btTrad.style.display = "none";
            btEnd.style.display = "block";
        }

    },false);
    ajaxTests();



})