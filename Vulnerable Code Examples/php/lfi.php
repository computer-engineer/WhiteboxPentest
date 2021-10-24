<form method="GET">
    <label>Select Timezone</label>
    <select name="timezone">
        <option value="america.php">America/New_York</option>
        <option value="asia.php">Asia/Singapore</option>
    </select>
    <input type="submit" value="Display time"/>
</form>

<?php
#Payload: ../../../../../../etc/passwd

#Insecure Implementation
if(isset($_GET['timezone'])){
    $timezone=$_GET['timezone'];
}else{
    $timezone='america.php';
}

/*Secure Implementation
if(isset($_GET['timezone']) and $_GET['timezone']=='asia.php'){
    $timezone='asia.php';
}else{
    $timezone='america.php';
}
*/

include "lfi_modules/$timezone";

#Notes: Preventing Local File Inclusion vulnerabilities
#ID assignation – save your file paths in a secure database and give an ID for every single one, this way users only get to see their ID without viewing or altering the path
#Whitelisting  – use verified and secured whitelist files and ignore everything else
#Use databases – don’t include files on a web server that can be compromised, use a database instead
#Better server instructions – make the server send download headers automatically instead of executing files in a specified directory
?>

