function LadeSeite1() {
	window.location = "paperwork_change.php?paperwork=offer";
return;
}
function LadeSeite2() {
	window.location = "paperwork_change.php?paperwork=order";
return;
}
function LadeSeite3() {
	window.location = "paperwork_change.php?paperwork=delivery";
return;
}
function LadeSeite4() {
	window.location = "paperwork_change.php?paperwork=invoice";
return;
}
function LadeSeite5() {
	window.location = "payments_change.php";
return;
}
function LadeSeite6() {
	window.location = "type_list.php?type=article";
	return;
}
document.getElementById("button1").addEventListener("click", LadeSeite1);
document.getElementById("button2").addEventListener("click", LadeSeite2);
document.getElementById("button3").addEventListener("click", LadeSeite3);
document.getElementById("button4").addEventListener("click", LadeSeite4);
document.getElementById("button5").addEventListener("click", LadeSeite5);
document.getElementById("button6").addEventListener("click", LadeSeite6);
