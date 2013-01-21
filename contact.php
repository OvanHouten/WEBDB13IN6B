<!DOCTYPE html>
<html>
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" type="text/css" href="./contact_files/StandaardOpmaak.css">
</head>

<body>
<div class = "banner">
	Contact
</div>
<div class=menu>
	<a href = "index.html"> Forum </a> |
	<a href = "profile.html"> Profile </a> |
	<a href = "login.html"> Login </a> | 
	<a href = "config page.html"> Admin Panel </a> |
	<a href = "issues.html"> Issues </a> |
	<a href = "contact.html"> Contact </a>
</div>

<form id="contactform" action="contact.html#" method="post">
    <div class="row">
        <label for="name">Name*</label>
        <span class="fieldbox"><input type="text" name="name" id="name" value=""></span>
    </div>
    <div class="row">
        <label for="email">Email*</label>
        <span class="fieldbox"><input type="text" name="email" id="email" value=""></span>
    </div>
    <div class="row">
        <label for="msg">Message</label>
        <span class="msgbox"><textarea class="area" id="msg" name="msg" rows="8" cols="30"></textarea></span>
    </div>

    <input type="submit" value="Send" id="sendbutton" name="sendbutton">
    <p>Fields with "*" are required field.</p>
</form>
</body>
</html>