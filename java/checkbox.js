function studCheck() {
    let total = document.querySelectorAll('input[type="checkbox"]:checked').length;
    if (total == 5){
        document.getElementById("requi").style.display = "";
    }else{
        document.getElementById("requi").style.display = "none";
    }
  }