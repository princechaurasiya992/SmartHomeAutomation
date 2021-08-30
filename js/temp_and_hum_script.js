setInterval(tempAndHumFun, 5000);

function tempAndHumFun() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const tempArr = this.responseText.split(" ");
            const humArr = this.responseText.split(" ");
            const tempArr2 = tempArr[1].split(",");
            const humArr2 = humArr[5].split(",");
            document.getElementById("temp").innerHTML = tempArr2[0] + " C";
            document.getElementById("hum").innerHTML = humArr2[0] + " %";
        }
    };
    xhttp.open("POST", "temp_and_hum_script.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}