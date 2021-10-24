<form method="GET">
    <input type="text" name="userParameter" placeholder="type your input" />
    <input type="submit"/>
</form>

<?php
#Payload: <script>alert(document.domain)</script>

#Insecure Implementation
if(isset($_GET['userParameter'])){
    echo "Value passed is: ".$_GET['userParameter'];
}

/*Secure Implementation
if(isset($_GET['userParameter'])){
    echo "Value passed is: ".htmlspecialchars($_GET['userParameter']);
}
*/

#Notes
#Avoid addslashes() since it can be bypassed
#Use HTML Purifier if it's required to accept input from your users
#https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html
?>