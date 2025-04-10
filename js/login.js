$(document).ready(function(){
    $("#loginForm").validate({
        // Definiamo le nostre regole di validazione del form
        rules : {
            username : {
              required : true,
            },
            password : {
                required : true,
            },
        },
        // Personalizziamo i mesasggi di errore
        messages: {
            username: {
                required: "Inserisci l'username!",
            },
            password: {
                required: "Inserisci la password!",
            }
        },
        // Settiamo il submit handler per la form
        submitHandler: function(form) {
            form.submit();
        }
    });
});
