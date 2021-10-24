<b>Check if server is up</b>
<form method="POST">
    <input type="text" name="ip" placeholder="Enter server IP"/>
    <input type="submit" value="check status"/>
</form>

<?php
#Payload: 127.0.0.1;cat /etc/passwd

if(isset($_POST['ip'])){
    #Insecure Implementation
    echo passthru('ping -c 1 '.$_POST['ip']);

    /*Secure Implementation
    if ($_POST['ip'] = filter_input(INPUT_POST,'ip',FILTER_VALIDATE_IP)) {
        echo passthru('ping -c 1 '.$_POST['ip']);
    }else {
        die("Please provide a valid IP address");
    }*/
}

#Notes
#system() => Execute an external program and displays the output.
#passthru() => Same than system, but casts the output in binary "as is" from the shell to the PHP output (typically the HTTP response).
#exec() => Captures the output and only the last line of the output into a string.
#shell_exec() => Same than exec, but capturing full output, not only the last line.

#Prevention: By far the most effective way to prevent OS command injection vulnerabilities is to never call out to OS commands from application-layer code. In virtually every case, there are alternate ways of implementing the required functionality using safer platform APIs
?>