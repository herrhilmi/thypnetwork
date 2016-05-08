/**
 * Created by Admin on 07/05/2016.
 */
$(function(){

    $(".commenter").click(function(){
        commenter(this);
    });

});



/***
 * pour commenter
 * */
function commenter(btn){
    var idAnnonce = $(btn).parent().find('input').val();
    var msg = $(btn).parent().find('textarea').val();
    if(!!msg){
        $.ajax({
            url : lien_commentaire,
            data: {annonce : idAnnonce, msg : msg},
            type:'POST',
            success:function(data){
                console.log('Success');
            },
            error: function(data){
                console.log('error');
            }
        });
    }

}



/**
 * pour afficher les commentaires
 * */
function afficherCommentaires(){

}