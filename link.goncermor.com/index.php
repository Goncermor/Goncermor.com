require '../vendor/autoload.php';
$client = new MongoDB\Client("mongodb://127.0.0.1:27017/");
$collection = $client->Goncermor->Links;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
    $document = $collection->findOne(['key' => $_GET['q']]);  
    $url = $document->url;
    if ($document == NULL)
        echo "<h4>Link not found on the database</h4>";
    else {
        echo '<h4>Redirecting in 3 seconds, click <a href="' . $url . '" >here</a> if it does not redirect.</h4>';
        header("refresh:3;url=" . $url);
    }
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = file_get_contents('php://input');
    if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
        echo "Invalid URL";
        die;
    }

    $code = GenID();
    echo "https://link.goncermor.com/?q=" . $code;
    $collection->insertOne( [ 'key' => $code, 'url' => $url] );
    die;
}
function GenID()
{
    $Dic = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $result = "";
    for ($x = 0; $x <= 10; $x++) {
        $result .= $Dic[rand(0, strlen($Dic) - 1)];
    }
    return $result;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goncermor link shortner</title>
    <script>
        function GetURL() {
            var Req = new XMLHttpRequest();
            Req.open("post", "https://link.goncermor.com/", false);
            Req.send(document.getElementById('url').value);
            document.getElementById("body").innerHTML = "Your url is: " + Req.response;
        }
    </script>
</head>
<body id="body">
    <input id="url" type="text">
    <input type="submit" onclick="GetURL()" value="Get URL">
</body>
</html>
