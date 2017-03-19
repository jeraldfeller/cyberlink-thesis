var XMLHttpRequestObject = false;

if (window.XMLHttpRequest)
{
    XMLHttpRequestObject = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}



function deleteProduct(productId, btn, spinner)
{
    if(XMLHttpRequestObject)
    {

        XMLHttpRequestObject.open("POST", "http://admin.cyberlink.com/ajax/products/function.php?action=delete");


        XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        XMLHttpRequestObject.onreadystatechange = function()
        {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
            {
                var returnedData = XMLHttpRequestObject.responseText;

                $table = $('#datatable-responsive').DataTable();
                $table.ajax.reload(function(){
                    $('.editTooltip').tooltip({title: "Edit", placement: "top", trigger: "hover"});
                    $('.deleteTooltip').tooltip({title: "Remove", placement: "top", trigger: "hover"});
                });
                loadSpinner(btn, 'hide', spinner);
                pNotifyEvent(false, 'success',  'Product Successfully Deleted');
                $('#modalDeleteProduct').modal('hide');





            }else if (XMLHttpRequestObject.status == 408 || XMLHttpRequestObject.status == 503){
                pNotifyEvent(true, 'error', 'Ops... Something went wrong, please try again.')
            }
        }


        loadSpinner(btn, 'show', spinner);

        XMLHttpRequestObject.send("param=" + productId);


    }
    return false;
}


function borrowProduct(data, btn, spinner)
{
    if(XMLHttpRequestObject)
    {

        XMLHttpRequestObject.open("POST", "http://admin.cyberlink.com/ajax/products/function.php?action=borrow");


        XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        XMLHttpRequestObject.onreadystatechange = function()
        {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
            {
                var returnedData = XMLHttpRequestObject.responseText;

                if(returnedData == true){
                    pNotifyEvent(false, 'success',  'Product Successfully Updated');
                }else{
                    pNotifyEvent(true, 'error', 'Ops... Something went wrong, please try again.')
                }
                $table = $('#datatable-responsive').DataTable();
                $table.ajax.reload();
                loadSpinner(btn, 'hide', spinner);
                $('#modalBorrowProduct').modal('hide');

            }else if (XMLHttpRequestObject.status == 408 || XMLHttpRequestObject.status == 503){

            }
        }


        loadSpinner(btn, 'show', spinner);

        XMLHttpRequestObject.send("param=" + JSON.stringify(data));


    }
    return false;
}