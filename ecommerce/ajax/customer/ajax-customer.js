var XMLHttpRequestObject = false;

if (window.XMLHttpRequest)
{
    XMLHttpRequestObject = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}


function loginAction(data)
{
    if(XMLHttpRequestObject)
    {

        XMLHttpRequestObject.open("POST", "http://cyberlink.com/ajax/customer/function.php?action=login");


        XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        XMLHttpRequestObject.onreadystatechange = function()
        {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
            {
                var returnedData = XMLHttpRequestObject.responseText;
                if(returnedData == true){
                   window.location.href = 'index';
                }else if (returnedData == false){
                    $('#proccessing').css('display', 'none');
                    $('#login').css('display', 'inline');
                    $('#register').css('display', 'inline');
                   $('#loginMsg').html('<div class="alert alert-error"><strong>Incorrect Email or Password</strong></div>');
                }



            }else if (XMLHttpRequestObject.status == 408 || XMLHttpRequestObject.status == 503){
                pNotifyEvent(true, 'error', 'Ops... Something went wrong, please try again.')
            }
        }


        XMLHttpRequestObject.send("param=" + JSON.stringify(data));


    }
    return false;
}
