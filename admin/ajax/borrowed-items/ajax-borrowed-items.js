var XMLHttpRequestObject = false;

if (window.XMLHttpRequest)
{
    XMLHttpRequestObject = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}



function returnItems(data, btn, spinner)
{
    if(XMLHttpRequestObject)
    {

        XMLHttpRequestObject.open("POST", "http://admin.cyberlink.com/ajax/borrowed-items/function.php?action=return");


        XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        XMLHttpRequestObject.onreadystatechange = function()
        {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
            {
                var returnedData = XMLHttpRequestObject.responseText;

                if(returnedData == true){
                    pNotifyEvent(false, 'success',  'Product Successfully Returned');
                }else{
                    pNotifyEvent(true, 'error', 'Ops... Something went wrong, please try again.')
                }
                $table = $('#datatable-responsive').DataTable();
                $table.ajax.reload();
                loadSpinner(btn, 'hide', spinner);
                $('#modalReturnProduct').modal('hide');

            }else if (XMLHttpRequestObject.status == 408 || XMLHttpRequestObject.status == 503){

            }
        }


        loadSpinner(btn, 'show', spinner);

        XMLHttpRequestObject.send("param=" + JSON.stringify(data));


    }
    return false;
}