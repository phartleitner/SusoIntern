var continue = false;
var school ="";
var update = false;


/**
* navigation function forward
* includes check for completeness
*/

function nextPage(nr) {

switch(nr) {
case 2:
    continue = checkChildData();
    if (continue == true) {
        $('#info').hide();
        $('#child').show;  
    }
    

}