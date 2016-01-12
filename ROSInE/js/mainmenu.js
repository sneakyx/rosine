function LadeSeite1() {
	window.location = "offers.php";
return;
}
function LadeSeite2() {
	window.location = "orders.php";
return;
}
function LadeSeite3() {
	window.location = "deliveries.php";
return;
}
function LadeSeite4() {
	window.location = "invoices.php";
return;
}
function LadeSeite5() {
	window.location = "payments.php";
return;
}
function LadeSeite6() {
	window.location = "articles.php";
	return;
}
document.getElementById("button1").addEventListener("click", LadeSeite1);
document.getElementById("button2").addEventListener("click", LadeSeite2);
document.getElementById("button3").addEventListener("click", LadeSeite3);
document.getElementById("button4").addEventListener("click", LadeSeite4);
document.getElementById("button5").addEventListener("click", LadeSeite5);
document.getElementById("button6").addEventListener("click", LadeSeite6);
