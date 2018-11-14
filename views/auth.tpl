<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ title }}</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../www/css/main.css" type="text/css"/>
    <script src="../www/js/jquery-3.3.1.min.js"></script>
    <script src="../www/js/main.js"></script>
</head>
<body>
    <div id="loginBox">
        login:<br>
        <input type="text" id="loginLogin" name="login" value=""/><br/>
        password:<br>
        <input type="password" id="loginPassword" name="password" value=""/><br/>
        <input type="button" onclick="login();" value="Войти"><br>
    </div>
</body>
</html>