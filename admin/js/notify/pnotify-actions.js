/**
 * Created by Grabe Grabe on 9/26/2016.
 */

function pNotifyEvent(error, type, message){


    if(error == false){
        var title = 'Success';
    }else{
        var title = 'Oh No!';

    }

    setTimeout(function(){

        new PNotify({
            title: title,
            text: message,
            type: type
        });

    },300);

}
