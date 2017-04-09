var XMLHttpRequestObject = false;

if (window.XMLHttpRequest)
{
    XMLHttpRequestObject = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}


function updateOrder(data)
{
    if(XMLHttpRequestObject)
    {

        XMLHttpRequestObject.open("POST", "http://admin.cyberlink.com/ajax/invoice/function.php?action=update");


        XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        XMLHttpRequestObject.onreadystatechange = function()
        {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
            {
                var returnedData = XMLHttpRequestObject.responseText;
                pNotifyEvent(false, 'success',  'Order Successfully Updated');
                setTimeout(function(){
                    window.location.href = returnedData;
                }, 1000)

            }else if (XMLHttpRequestObject.status == 408 || XMLHttpRequestObject.status == 503){
                pNotifyEvent(true, 'error', 'Ops... Something went wrong, please try again.')
            }
        }


        XMLHttpRequestObject.send("param=" + JSON.stringify(data));


    }
    return false;
}
