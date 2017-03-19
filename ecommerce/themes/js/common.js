
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31
        && (charCode < 48 || charCode > 57) && charCode != 45)
        return false;

    return true;
}

function showSpin(btn, bol){

    if(bol == true){
        $(btn).css('display', 'inline')
        $button = btn.split('-');
        $($button[0]).attr('disabled', true);
    }else{
        $(btn).css('display', 'none')
        $($button[0]).attr('disabled', false);
    }


}
/*
 function formatDateFromYMD(inputDate) {
 var date = new Date(inputDate);
 if (!isNaN(date.getTime())) {
 // Months use 0 index.
 return date.getMonth() + 1 + '/' + date.getDate() + '/' + date.getFullYear();
 }
 }
 */
function formatDateFromYMD(inputDate) {
    var date = new Date(inputDate);
    if (!isNaN(date.getTime())) {
        // Months use 0 index.
        return date.getUTCMonth() + 1 + '/' + date.getUTCDate() + '/' + date.getUTCFullYear();
    }
}


function formatCurrency(elem) {

    var num = elem.value;

    // Remove any characters other than numbers and periods from the string, then parse the number
    var nNumberToFormat = parseFloat( String(num).replace(/[^0-9\.]/g, '') );
    // Escape when this number is invalid (parseFloat returns NaN on failure, we can detect this with isNaN)
    if( isNaN(nNumberToFormat) ) { nNumberToFormat = 0; }

    // Split number string by decimal separator (.)
    var aNumberParts = nNumberToFormat.toFixed(2).split('.');

    // Get first part = integer part
    var sFirstPart = aNumberParts[0];
    // Determine the position after which to start grouping
    var nGroupingStart = sFirstPart.length % 3;
    // Shift three to the right when first group is empty
    nGroupingStart += (nGroupingStart == 0) ? 3 : 0;
    // Start first result with ungrouped first part
    var sFirstResult = sFirstPart.substr(0, nGroupingStart);
    // Add grouped parts by looping through the remaining numbers
    for(var i=nGroupingStart, len=sFirstPart.length; i < len; i += 3) {
        sFirstResult += ',' + sFirstPart.substr(i, 3);
    }

    // Get second part = fractional part
    var sSecondResult = aNumberParts[1] ? '.' + aNumberParts[1] : '';

    // Combine the parts and return the result
    s = sFirstResult + sSecondResult;

    elem.value = s;


}


function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}


function loadSpinner(btn, action, elem){


    if(action == 'show'){
        //btn.attr('disabled', false);
        btn.disable = true;
        $(elem).css('opacity', '9');
    }else if(action == 'hide'){
        btn.disable = false;
        $(elem).css('opacity', 0);
    }
}