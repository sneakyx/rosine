/*
 * This file is only a file to print out the orders and offer and so on
 * It has to be used and can't be inside the html, because of the 
 * security policy!
 */

function printPageNow(){
	window.print();
}
window.addEventListener("load", printPageNow, false);