$(document).ready(function(){
    //la piantina torna blurrata ad ogni cambiamento dei campi del form, per evitare di prenotare
    //con dati inseriti precedentemente
    $("#data,#ora,#reset-btn,#nome,#cognome,#telefono,#email").click(function(){
        $("#piant_1").css({display: 'grid'});
        $("#piant_2").css({display: 'none'});
        for(var j=0; j<=10; j++){
            $(".tavolo"+(j).toString()).removeClass("grigio");
            $(".tavolo"+(j).toString()).closest("a").attr("href","#");
        }
    }); 
    $("#myForm").validate({
        // Definiamo le nostre regole di validazione per il form
        rules : {
            nome : {
              required : true,
              minlength: 2,
              maxlength: 20
            },
            cognome : {
                required : true,
                minlength: 2,
                maxlength: 20
            },
            telefono : {
                required : true,
                minlength: 10,
                maxlength: 10,
                number : true
            },
            email : {
                email:true
            }
        },
        // Personalizziamo i messaggi di errore
        messages: {
            nome: {
                required: "Inserisci il tuo nome!",
                minlength: "Il nome è troppo corto.",
                maxlength: "Il nome è troppo lungo."
            },
            cognome: {
                required: "Inserisci il tuo cognome!",
                minlength: "Il cognome è troppo corto.",
                maxlength: "Il cognome è troppo lungo."
            },
            telefono: {
                required: "Inserisci il tuo numero!",
                minlength: "Il numero è troppo corto.",
                maxlength: "Il numero è troppo lungo.",
                number: "Inserire un numero valido."
            },
            email: {
                email: "Inserisci un'e-mail valida."
            }
        },
        submitHandler: function() {
            $("#piant_1").css({display: 'none'});
            $("#piant_2").css({display: 'grid'});
        }
    });
    $("#dispo-btn").submit(function(e){
        e.preventDefault();
    });
    //chiamata ajax che tramite data e ora inseriti colora nella piantina solo i tavoli disponibili
    $("#dispo-btn").click(function(){
        $("#dispo-btn").submit();
        var data = document.myFormName.data.value;
        var ora = document.myFormName.ora.value;
        $.ajax({
            url: "../php/prenotazione.php",
            type: "POST",
            data: {data,ora},
            success: function(result){
                var res = result.split(" ");
                for (var i = 0; i <= res.length; i++){
                    for(var j=1; j<=10; j++){
                        if(res[i]==j){
                            $(".tavolo"+(j).toString()).addClass("grigio");
                            $(".tavolo"+(j).toString()).closest("a").removeAttr("href");
                        }
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
            }
        })
    });
    //chiamata ajax che dopo aver cliccato il tavolo scelto effettua la prenotazione tramite php
    $(".active").click(function(){
        var tav_num = $(this).text();
        var data = document.myFormName.data.value;
        var ora = document.myFormName.ora.value;
        var nome = document.myFormName.nome.value;
        var cognome = document.myFormName.cognome.value;
        var telefono = document.myFormName.telefono.value;
        var email = document.myFormName.email.value;
        //alert di conferma
        if(confirm("Hai scelto il tavolo "+tav_num+
                ", alle ore "+ora+" del "+data+".\nConfermi?")){
            $.ajax({
                url: "../php/prenotazione.php",
                type: "POST",
                data: {data,ora,tav_num,nome,cognome,telefono,email},
                success: function(result){
                    alert('Prenotazione effettuata!')
                    $(".tavolo"+(tav_num).toString()).addClass("grigio");
                    $(".tavolo"+(tav_num).toString()).closest("a").removeAttr("href");
                    //Aggiorniamo la pagina così da resettare la form
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(textStatus, errorThrown);
                }
            })
        }
    });
});
