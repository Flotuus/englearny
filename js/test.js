$(document).ready(function() {

    let themeTest = document.getElementById("selectTheme");
    let btTheme = document.getElementById("btTheme");
    let labelTheme = document.getElementById("labelTheme");
    let question = document.getElementById("question");
    let reponse = document.getElementById("reponse");
    let tests = [];
    question.style.display = "none";
    reponse.style.display = "none";
    

    function ajaxTests(){
        var request= $.ajax({
            url: "http://serveur1.arras-sio.com/symfony4-4060/englearny/public/api/tests?page=1", 
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
            alert ('erreur');
        });
    }

    btTheme.addEventListener("click", function () {
        if (themeTest.value != 0){
            themeTest.style.display = "none"
            btTheme.style.display = "none"
            labelTheme.style.display = "none"
            question.style.display = "block"
            reponse.style.display = "block"
            
            
        }    
    },false)

    ajaxTests();



})