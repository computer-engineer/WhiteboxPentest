<b>eLibrary</b>
<form method="POST">
  <input type="text" name="searchTerm" placeholder="Type book name"/>
  <input type="submit" value="search">
</form>

<?php
#Payload: 'or 1=1;##
#Payload: 'or 1=2;##
#payload: war 101'AND (SELECT SUBSTRING(password,1,1) FROM password)='a'#'

#Create connection
$conn = new mysqli("127.0.0.1", "root", "", "books");

#Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

#Insecure Implementation
$sql = "SELECT * from authors WHERE Name='".$_POST['searchTerm']."'";
$result = $conn->query($sql);

/*Secure Implementation
$stmt=$conn->prepare("SELECT * from authors WHERE Name= ?");
$searchTerm=$_POST['searchTerm'];
$stmt->bind_param("s",$searchTerm);
$stmt->execute();
$result = $stmt->get_result();*/

#Fetch & dispaly results
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " | Name: " . $row["name"]. " | Email: " . $row["email"]. "<br>";
  }
} else {
  echo "0 results";
  echo $conn->error; #This line makes it error based, if you remove this line an attacker will not be able to see DB errors and will have to rely on boolean/time based techniques
}
$conn->close();

?> 
