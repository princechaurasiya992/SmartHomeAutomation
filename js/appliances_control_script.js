function appliancesStateBtnFun(btn_id, state, element_id) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(element_id).innerHTML = this.responseText;
            alertBoxFunction(this.responseText);
        }
    };
    xhttp.open("POST", "appliances_control_script.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("btn_id=" + btn_id + "&state=" + state);
}