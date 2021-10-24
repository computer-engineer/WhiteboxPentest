<b>Simple URL crawler</b>
<form method="POST">
   <a>http://</a><input type="text" name="url" placeholder="google.com"/>
    <input type="submit" value="crawl"/>
</form>

<?php
#Payload: 127.0.0.1
#Bypass Rebinding service: https://lock.cmpxchg8b.com/rebinder.html

if(isset($_POST['url'])){
    #Insecure Implementation
    crawl_page($_POST['url']);

    /*Secure Implementation
    There's no one step solution, for mitigation, you'll have to apply several defenses at multiple OSI layers 
    Ref: https://cheatsheetseries.owasp.org/cheatsheets/Server_Side_Request_Forgery_Prevention_Cheat_Sheet.html
    #Following implementation does a very basic input validation and restricts private IP's but does not protect against DNS Rebinding attack, AWS metadata service read, protocol whitelisting etc, check Notes for list of security checks
    
    $user_ip = gethostbyname($_POST['url']);    #Get host IP
     
    if(filter_var(          #Validate if the host resolves to a public IP
    $user_ip, 
    FILTER_VALIDATE_IP, 
    FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE |  FILTER_FLAG_NO_RES_RANGE)==TRUE){
    crawl_page($_POST['url']);}
    else{echo 'Provide a valid public host';}*/
}

function crawl_page($page){
    $page = ''; $fh = fopen('http://'.$_POST['url'],'r') or die($php_errormsg); 
    while (! feof($fh)) { $page .= fread($fh,1048576); } fclose($fh); 
    echo '<textarea rows="10" cols="50">'.$page.'</textarea>';
}

/*Notes: Security Checks & Recommendations: 
    - Perform input validation to confirm if user supplied input is a valid public IP or domain 
    - Perform a DNS resolution to prevent DNS pinning bypass
    - Have a fixed set of whitelisted URL's where requests can be made if possible 
    - Predefined protocol over which application will make a call (HTTP/HTTPS), don't accept user supplied protocol
    - Show predefined responses instead of raw content from the page if possible
    - More Checks. . .*/
?>