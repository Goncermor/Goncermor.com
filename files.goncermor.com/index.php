<?php
require '../vendor/autoload.php';
$client = new MongoDB\Client("mongodb://127.0.0.1:27017/");
$collection = $client->Goncermor->Files;

$filename;
if (isset($_GET['f'])) {
    $document = $collection->findOne(['key' => $_GET['f']]); 
    if ($document == NULL)
	{
		echo "<body style=\"font-family: Segoe UI;\">Link not found on the database</body>";
		die;
	}
	if (isset($_GET['dl'])) {
		if ($document->count === 0) {
			echo "<body style=\"font-family: Segoe UI;\">Sorry, this link has expired. Ask Goncermor for the file again ¯\_(ツ)_/¯</body>";
			die;
		} else {
			if ($document->count !== -1) {
				$result = $collection->updateOne(
					[ 'key' => $_GET['f'] ],
					[ '$set' => ['count' => $document->count - 1]]
				 );
			}
		}
		header('Content-Type: ' . $document->type);
		header('Content-Disposition: attachment; filename=' . $document->filename);
		header('Content-Length: ' . filesize("/data_hdd/Files/" . $document->path));
		flush();
		readfile("/var/www/files/" . $document->path);
		die;
	} else {
		
		if ($document->count === 0) {
			echo "<body style=\"font-family: Segoe UI;\">Sorry, this link has expired. Ask Goncermor for the file again ¯\_(ツ)_/¯</body>";
			die;
		}
		$filename = $document->filename;
	}
} else {
	echo "No id provided";
	die;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="title" content="<?php echo $filename ?>">
	<meta name="description" content="Link from goncermor.com">

	<meta property="og:type" content="website">
	<meta property="og:url" content="https://goncermor.com/">
	<meta property="og:title" content="<?php echo $filename ?>">
	<meta property="og:description" content="Link from goncermor.com">
	<meta property="og:image" content="https://cdn.goncermor.com/img/cdn.png">

	<meta property="twitter:card" content="summary">
	<meta property="twitter:url" content="https://goncermor.com/">
	<meta property="twitter:title" content="<?php echo $filename ?>">
	<meta property="twitter:description" content="Link from goncermor.com">
	<meta property="twitter:image" content="https://cdn.goncermor.com/img/cdn.png">


	<meta name="robots" content="noindex, nofollow">
	<meta name="author" content="Goncermor">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goncermor file downloading</title>
    <script>
		const SL = m => new Promise(r => setTimeout(r, m));
		let Body = document.getElementById('body');
		window.onload = async function() {
			for (let i = 5; i > 0; i--) {
				await SL(800);
				Body.innerHTML = "Downloading File in " + i;
			}
			await SL(1000);
			Body.innerHTML = "Downloading..."
			await SL(500);
			window.location.assign("https://files.goncermor.com/?f=<?php echo $_GET['f'] ?>&dl")
		};
    </script>
</head>
<body id="body" style="font-family: Segoe UI;">Downloading File in 5</body>
</html>
