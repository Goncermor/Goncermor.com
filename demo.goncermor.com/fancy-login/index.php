<?php
$encryption_iv = '0744641209477128'; // random 16 digit number
$encryption_key = "Goncermor-Fancy-Login"; // here a password for the cookie data (something secure)

if (isset($_COOKIE['data'])) {
    $cookieJson = json_decode(openssl_decrypt($_COOKIE['data'], "AES-128-CTR", $encryption_key, 0, $encryption_iv));
if (ProcessInfo($cookieJson->username, $cookieJson->password) === true) {
  echo "<style>* {font-family: arial;} </style>";
  echo "Logged in as: " . $cookieJson->username . "<br/>";
  echo "Used password: " . $cookieJson->password . "<br/>";
  echo '<a href="logout.php"><button>Logout</button></a>';
  die;
} else {
  http_response_code(403);
  unset($_COOKIE['data']); 
  setcookie('data', null, -1, '/'); 
}}
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $input = file_get_contents("php://input");
  $json = json_decode($input);
  if (ProcessInfo($json->username, $json->password) === true) {
    http_response_code(201);
    $encryption = openssl_encrypt($input, "AES-128-CTR", $encryption_key, 0, $encryption_iv);
    echo json_encode(array('status' => true, 'data' => $encryption));
  } else {
    http_response_code(403);
    echo json_encode(array('status' => false));
  }
  die;
}
function ProcessInfo($user, $password) {
  // place here the code to check if the user exists in your database
  // return true to save the login and continue
  // return false to send invalid password
  return true;
}

// By Goncermor
?>
<!DOCTYPE html>
<html lang="en">
<link>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script>
        const Sleep = m => new Promise(r => setTimeout(r, m));
let InputError = false;
async function send() {
  let usernameInput = document.getElementById('username');
  let passwordInput = document.getElementById('password');
  if (usernameInput.value.length <= 8) {
      InputError = true;
      usernameInput.style.borderColor = "#ff0000da";
      console.log("Username is valid.");
  } else {console.log("Username is valid.");}
  if (passwordInput.value.length <= 8) {
      InputError = true;
      passwordInput.style.borderColor = "#ff0000da";
      console.log("Password is not valid.");
  } else {console.log("Password is valid.");}
  if (InputError == true) {
    InputError = false;
    await Sleep(2000);
    usernameInput.style.borderColor = "#ffffff6a";
    passwordInput.style.borderColor = "#ffffff6a";
    return;
  } else {console.log("Password is not valid.");}
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "https://demo.goncermor.com/fancy-login/", false);
  xhr.setRequestHeader('Content-Type', 'application/json');
  console.log("Request opened...");
  let data = JSON.stringify({
    username: usernameInput.value,
    password: passwordInput.value
  });
  console.log("Sending: " + data);
  xhr.send(data);
  console.log("Request sent.");
  let cookiedata = JSON.parse(xhr.response);
  console.log("Data parsed: " + xhr.response);
  if (cookiedata.status == true) {
    console.log("Password is correct");
    const d = new Date();
    d.setTime(d.getTime() + (31*24*60*60*1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = "data=" + cookiedata.data + ";" + expires + ";path=/";
    console.log("Cookie created");
    console.log("Reloading...");
    await Sleep(1000);
    window.location.reload();
  } else {
    console.log("Password or Username is incorrect");
    usernameInput.style.borderColor = "#ff0000da";
    passwordInput.style.borderColor = "#ff0000da";
    await Sleep(2000);
    usernameInput.style.borderColor = "#ffffff6a";
    passwordInput.style.borderColor = "#ffffff6a";
  }
}
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=MuseoModerno:wght@300&display=swap');
* {
  padding: 0;
  margin: 0;
}
html {
  height: 100%;
  width: 100%;
}
body {
  font-family: 'MuseoModerno';
  height: 100%;
  background-image: url("img/bg.webp");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: 50% 50%;
  box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.15);
  transition: background-image 3s ease;
}
.bg-author {
  width: 100%;
  position: absolute;
  bottom: 6px;
}
.bg-author p {
  color: #afafaf;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  text-align: center;
}
#form {
  user-select: none;
  text-align: center;
  padding-top: 15px;
  border-radius: 15px;
  border-width: 1px;
  border-color: #ffffff6a;
  border-style: solid;
  width: 250px;
  height: 350px;
  background-color: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(10px);
  box-shadow: 0px 0px 20px 2px rgba(0,0,0,0.75);
}
h1 {
  color: #fff;
}
.container {
  height: 100%;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
::placeholder {
  color: #a7a7a7;
}
input {
  font-family: 'MuseoModerno';
  font-size: 16px;
  color:#cacaca;
  transition: border-color .3s ease-in-out;
  background-color: transparent;
  border-width: 1px;
  border-radius: 6px;
  border-color: #ffffff6a;
  outline: none;
  border-style: solid;
  text-decoration: none;
}
input[type=username], input[type=password] {
  letter-spacing: 0.04em;
  width: 180px;
  height: 28px;
  padding-left: 6px;
  margin-top: 16px;
}
#username:focus, #password:focus {
  border-color: #c4c4c4;
}
input[type=button] {
  margin-top: 25px;
  width: 100px;
  height: 28px;
}
    </style>
  </head>
<body>
<a href="https://github.com/Goncermor/Fancy-Login" class="github-corner" aria-label="View source on GitHub"><svg width="80" height="80" viewBox="0 0 250 250" style="fill:#fff; color:#151513; position: absolute; top: 0; border: 0; right: 0;" aria-hidden="true"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"></path></svg></a><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style>
  <div class="container">
    <div id="form">
      <h1>Login</h1>
      <input id="username" type="username" placeholder="Username"></input>
      <input id="password" type="password" placeholder="Password"></input>
      <input type="button" onclick="send()" value="Login"></input>
    </div>
  </div>
    <div class="bg-author"><p>By Goncermor</p></div>
</body>
</html>
