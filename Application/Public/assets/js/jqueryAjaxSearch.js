$(function(){
   $('#link-login').click(function(){
    var search = $('#Search').val();

    $.ajax({ 
        method:'POST',
        type:'POST',
        url:'SerachController.php',
        dataType:json,

    });

        alert(search + 'ok');

        search.done(function(e){
            console.log("deu bom");
            console.log(e);
        });

        search.fail(function(e){
            console.log("fodeu");
            console.log(e);
        });

    });
});



