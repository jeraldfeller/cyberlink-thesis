var XMLHttpRequestObject = false;

if (window.XMLHttpRequest)
{
    XMLHttpRequestObject = new XMLHttpRequest();
}
else if (window.ActiveXObject)
{
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
}


function addSupplier(data, btn, spinner)
{
    if(XMLHttpRequestObject)
    {

        XMLHttpRequestObject.open("POST", "http://admin.cyberlink.com/ajax/supplier/function.php?action=add");


        XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        XMLHttpRequestObject.onreadystatechange = function()
        {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
            {
                var returnedData = XMLHttpRequestObject.responseText;
                if(returnedData == true){
                    $table = $('#datatable-responsive').DataTable();
                    $('#addName').val('');
                    $('#addAddress').val('');
                    $('#addContactPerson').val('');
                    $('#addContactNo').val('');

                    $table.ajax.reload(function(){
                        $('.editTooltip').tooltip({title: "Edit", placement: "top", trigger: "hover"});
                        $('.deleteTooltip').tooltip({title: "Remove", placement: "top", trigger: "hover"});
                    });

                    pNotifyEvent(false, 'success',  'Supplier Successfully Added');
                }else if (returnedData == false){

                    pNotifyEvent(false, 'warning',  'Supplier Already Added');
                }

                loadSpinner(btn, 'hide', spinner);



            }else if (XMLHttpRequestObject.status == 408 || XMLHttpRequestObject.status == 503){
                pNotifyEvent(true, 'error', 'Ops... Something went wrong, please try again.')
            }
        }


        loadSpinner(btn, 'show', spinner);

        XMLHttpRequestObject.send("param=" + JSON.stringify(data));


    }
    return false;
}


function editSupplier(data, btn, spinner)
{
    if(XMLHttpRequestObject)
    {

        XMLHttpRequestObject.open("POST", "http://admin.cyberlink.com/ajax/supplier/function.php?action=edit");


        XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        XMLHttpRequestObject.onreadystatechange = function()
        {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
            {
                var returnedData = XMLHttpRequestObject.responseText;

                $table = $('#datatable-responsive').DataTable();
                $('#modalEditSupplier').modal('hide');

                $table.ajax.reload(function(){
                    $('.editTooltip').tooltip({title: "Edit", placement: "top", trigger: "hover"});
                    $('.deleteTooltip').tooltip({title: "Remove", placement: "top", trigger: "hover"});
                });
                loadSpinner(btn, 'hide', spinner);
                pNotifyEvent(false, 'success',  'Supplier Successfully Updated');




            }else if (XMLHttpRequestObject.status == 408 || XMLHttpRequestObject.status == 503){
                pNotifyEvent(true, 'error', 'Ops... Something went wrong, please try again.')
            }
        }


        loadSpinner(btn, 'show', spinner);

        XMLHttpRequestObject.send("param=" + JSON.stringify(data));


    }
    return false;
}

function deleteSupplier(catId, btn, spinner)
{
    if(XMLHttpRequestObject)
    {

        XMLHttpRequestObject.open("POST", "http://admin.cyberlink.com/ajax/supplier/function.php?action=delete");


        XMLHttpRequestObject.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

        XMLHttpRequestObject.onreadystatechange = function()
        {
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200)
            {
                var returnedData = XMLHttpRequestObject.responseText;

                $table = $('#datatable-responsive').DataTable();
                $('#addName').val('');
                $('#modalDeleteSupplier').modal('hide');

                $table.ajax.reload(function(){
                    $('.editTooltip').tooltip({title: "Edit", placement: "top", trigger: "hover"});
                    $('.deleteTooltip').tooltip({title: "Remove", placement: "top", trigger: "hover"});
                });
                loadSpinner(btn, 'hide', spinner);
                pNotifyEvent(false, 'success',  'Supplier Successfully Deleted');




            }else if (XMLHttpRequestObject.status == 408 || XMLHttpRequestObject.status == 503){
                pNotifyEvent(true, 'error', 'Ops... Something went wrong, please try again.')
            }
        }


        loadSpinner(btn, 'show', spinner);

        XMLHttpRequestObject.send("param=" + catId);


    }
    return false;
}