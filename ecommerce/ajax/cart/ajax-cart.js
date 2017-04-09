var XMLHttpRequestObject = false;

if (window.XMLHttpRequest)
{
    XMLHttpRequestObject = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}


function addToCart(data)
{
    if(XMLHttpRequestObject)
    {

        XMLHttpRequestObject.open("POST", "http://cyberlink.com/ajax/cart/function.php?action=add");


        XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        XMLHttpRequestObject.onreadystatechange = function()
        {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
            {
                var returnedData =  $.parseJSON(XMLHttpRequestObject.responseText);
                $('#headerItemCount').html(returnedData['count']);
                $('#bodyItemCount').html(returnedData['count']);
                $('#shoppingCartCount').html(returnedData['count']);
                $('#headerTotalPartial').html(number_format(returnedData['partialTotal'], '2', '.', ','));
                $('#bodyTotalPartial').html(number_format(returnedData['partialTotal'], '2', '.', ','));
                $('#bodyCartTotalPartial').html(number_format(returnedData['partialTotal'], '2', '.', ','));

                $('#modalAddCart').modal('show');

            }else if (XMLHttpRequestObject.status == 408 || XMLHttpRequestObject.status == 503){
                pNotifyEvent(true, 'error', 'Ops... Something went wrong, please try again.')
            }
        }


        XMLHttpRequestObject.send("param=" + JSON.stringify(data));


    }
    return false;
}

function checkOut(data)
{
    if(XMLHttpRequestObject)
    {

        XMLHttpRequestObject.open("POST", "http://cyberlink.com/ajax/cart/function.php?action=checkOut");


        XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        XMLHttpRequestObject.onreadystatechange = function()
        {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
            {
                var returnedData =  $.parseJSON(XMLHttpRequestObject.responseText);
                if(returnedData['error'] == false){
                    window.location.href = "invoice?id="+returnedData['invoice'];
                }else{
                    alert(returnedData['message']);
                    $('#modalLogin').modal('show');
                }

            }else if (XMLHttpRequestObject.status == 408 || XMLHttpRequestObject.status == 503){
                pNotifyEvent(true, 'error', 'Ops... Something went wrong, please try again.')
            }
        }


        XMLHttpRequestObject.send("param=" + JSON.stringify(data));


    }
    return false;
}
