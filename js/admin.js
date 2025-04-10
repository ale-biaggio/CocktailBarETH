$(document).ready(function(){
    //chiamata ajax per cancellare la prenotazione nel database tramite php
    $(".cestino-btn").click(function(){
        //ottenimento dati
        var nome = $(this).closest(".row").children("#nome").text();
        var cognome = $(this).closest(".row").children("#cognome").text();
        //alert di conferma
        if(confirm("Confermi di voler cancellare la prenotazione di"+nome+cognome+'?')){
            var telefono = $(this).closest(".row").children("#telefono").text();
            var data = $(this).closest(".row").children("#data").text();
            var ora = $(this).closest(".row").children("#ora").text();
            var tavolo = $(this).closest(".row").children("#tavolo").text();
            var id = $(this).closest(".row").children("#id").text();
            var del = "true";
            $.ajax({
                url: "../php/prenotazione.php",
                type: "POST",
                data: {nome,cognome,telefono,data,ora,tavolo,id,del},
                success: function(result){
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(textStatus, errorThrown);
                }
            })  
        }
        
    
    });
    //i pulsanti data, ora, e tavolo vengono disabilitati con un criterio che 
    //impedisce di prenotare con dati inseriti in precedenza
    $("#ora").prop("disabled",true);
    $("#tav_num").prop("disabled",true);
    $("#data").change(function(){
        $("#ora").prop("disabled",true);
        $("#tav_num").prop("disabled",true);
    });
    $("#data").change(function(){
        $("#ora").prop("disabled",false);
    });
    $("#ora").change(function(){
        $("#tav_num").prop("disabled",true);
    });
    $("#ora").change(function(){
        $("#tav_num").prop("disabled",true);
    });
    //selezionata l'ora, viene fatta la chiamata ajax per popolare la tendina "tavoli" 
    //con i tavoli effettivamente disponibili
    $("#ora").change(function(){
        $("#tav_num").prop("disabled",false);
        for(var i = 1; i<=10; i++){
            $("#"+i.toString()).remove();        
        }
        for(var i = 1; i<=10; i++){
            $("#tav_num").append("<option id="+i.toString()+">"+i.toString()+"</option>");
        }
        var data = document.myFormName.data.value;
        var ora = document.myFormName.ora.value;
        $.ajax({
            url: "../php/prenotazione.php",
            type: "POST",
            data: {data,ora},
            success: function(result){
                var res = result.split(" ");
                for (var i = 0; i <= res.length; i++){
                    $("#"+res[i]).remove();
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
            }
        })
    });
    $("#myForm").validate({
        // Definiamo le nostre regole di validazione del form
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
            },
            data : {
                required:true,
            },
            ora : {
                required:true,
            },
            tav_num : {
                required:true,
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
            },
            data: {
                required: "Selezionare una data."
            },
            ora: {
                required: "Selezionare una data."
            },
            tav_num: {
                required: "Selezionare una data."
            }
        },
        submitHandler: function() {
            invio();
        }
    });
    //chiamata ajax che effettua tramite php la prenotazione
    function invio(){
        var nome = document.myFormName.nome.value;
        var cognome = document.myFormName.cognome.value;
        var telefono = document.myFormName.telefono.value;
        var email = document.myFormName.email.value;
        var data = document.myFormName.data.value;
        var ora = document.myFormName.ora.value;
        var tav_num = document.myFormName.tav_num.value;
        $.ajax({
            url: "../php/prenotazione.php",
            type: "POST",
            data: {nome,cognome,telefono,email,data,ora,tav_num},
            success: function(result){
                //Aggiorniamo la pagina così da resettare la form
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(textStatus, errorThrown);
            }
        })
    }
    
});
