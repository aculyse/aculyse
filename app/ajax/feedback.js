var Feedback = {
    send:function(description,url){
        $.ajax({
            type: 'POST',
            url: "../executers/feedback.php",
            data:"description=" + description + "&url=" + url ,
            dataType: 'html',
            success: function(html, textStatus) {

                if(html.toString()=="success"){
                    msgSuccess("Thank you for the feedback, We really appreciate it!!");
                }
                else{
                    msgWarning("Sorry, your feedback could not be processed");
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                msgError('an error just happened and we are embarassed and working on it');
            }
        });
    }
}