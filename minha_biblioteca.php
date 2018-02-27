<?php 
require_once("file:///F|/config.php");

$service_url = 'https://digitallibrary.zbra.com.br/DigitalLibraryIntegrationService/AuthenticatedUrl'; 
$curl = curl_init($service_url); 
  
// dados do aluno 
/*
echo $USER->username; 
echo "<br>";
echo $USER->firstname;
echo "<br>";
echo $USER->lastname;
echo "<br>";
echo $USER->email;
echo "<br>";

$firstName = 'Lusana'; 
$lastName = 'Verissimo'; 
$email = 'lusana.verissimo@gmail.com'; 

*/

$Nome = $USER->firstname; 
$primeiroNome = explode(" ", $Nome);

$firstName = $primeiroNome[0];
$lastName = $USER->lastname; 
$email = $USER->username; 

$curl_post_data = "<?xml version=\"1.0\" encoding=\"utf-8\"?> 
<CreateAuthenticatedUrlRequest 
xmlns=\"http://dli.zbra.com.br\" 
xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" 
xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"> 
<FirstName>$firstName</FirstName> 
<LastName>$lastName</LastName> 
<Email>$email</Email> 
<CourseId xsi:nil=\"true\"/> 
<Tag xsi:nil=\"true\"/> 
<Isbn xsi:nil=\"true\"/> 
</CreateAuthenticatedUrlRequest> 
"; 
 $content_size = strlen($curl_post_data); 
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 
curl_setopt($curl, CURLOPT_HTTPHEADER, array( 
    "Content-Type: application/xml; charset=utf-8",  
    "Host: digitallibrary.zbra.com.br", 
    "Content-Length: $content_size", 
    "Expect: 100-continue", 
    "Accept-Encoding: gzip, deflate", 
    "Connection: Keep-Alive", 
    "X-DigitalLibraryIntegration-API-Key: d0bd3271-d804-4af9-989e-ae9adf612aa6") 
); 
curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data); 
$curl_response = curl_exec($curl); 
  
if ($curl_response === false) { 
    echo curl_error($curl); 
    curl_close($curl); 
    die(); 
}else{
	echo "Usuário não Cadastrado.";
	echo "<br><br>Usuário: ".$USER->username; 
	echo "<br>";
	echo "Nome: ".$firstName;
	echo "<br>";
	echo "Sobrenome: ".$lastName;
	echo "<br>";
	echo "Email: ".$USER->email;
	echo "<br>";
}
curl_close($curl); 
 $xml = new SimpleXMLElement($curl_response); 
 if ($xml->Success != 'true') { 
    echo htmlspecialchars($result); 
    die(); 
} 
// user code below to redirect browser to the authenticated URL 
 

echo header('Location: ' . $xml->AuthenticatedUrl); 

 
//echo $xml->AuthenticatedUrl; 
die(); 

?> 