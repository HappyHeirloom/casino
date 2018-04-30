<?php
// Initialize the session
session_start();

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}
?>

<html>
<head>
	<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="roulettestyle.css"/>
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
  <link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
  <script src="js/modernizr.js"></script> <!-- Modernizr -->

	<script
				 src="https://code.jquery.com/jquery-3.2.1.min.js"
				 integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
				 crossorigin="anonymous"></script>

</head>
<body>

<h1>Hi, <b><?php echo $_SESSION['username'] ?></b> </h1>
<h1 class="rainbow-text" style="font-size:50px; text-align:center; padding-top:50px;"> Roulette </h1>


<div class="bigwrapper">
	<div class="coinbetwrap">
		<div class="coins" id="coins">
		</div>
		<input type="integer" id="amountgreen" placeholder="Enter bet on green " />
		<input type="integer" id="amountred" placeholder="Enter bet on red" />
		<input type="integer" id="amountblack" placeholder="Enter bet on black" />
	</div>

	<div class="wrapper">
		<a href="#"><div class="button animationred">
		ROLL
		</div></a>
	</div>
</div>


  <header>
  	<nav class="cd-stretchy-nav">
  		<a class="cd-nav-trigger" href="#0">
  			Menu
  			<span aria-hidden="true"></span>
  		</a>

  		<ul>
  			<li><a href="../index.php"><span>Home</span></a></li>
  			<li><a href="./roulette.php" class="active"><span>Roulette</span></a></li>
  			<li><a href="./coin.php"><span>Coin flip</span></a></li>
  			<li><a href="./shop.php"><span>Shop</span></a></li>
  			<!-- <li><a href="#0"><span>Contact</span></a></li> -->
  		</ul>

  		<span aria-hidden="true" class="stretchy-nav-bg"></span>
  	</nav>
  </header>

<script src="js/jquery-2.1.4.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->


<script>
var bet_amountgreen;
var bet_amountred;
var bet_amountblack;
var user_coins = parseInt(50);

$("#coins").html("coins: "+parseInt(user_coins));

$(document).ready(function(){
	var old_coins = parseInt(getCookie("coins"));
	if(old_coins != 0) {
		user_coins = parseInt(old_coins);
		console.log(old_coins+" recovered from cookies");
		updateCoins();
	}
});

var active = false;
$(".button").click(function(){
	bet_amountgreen = $("#amountgreen").val();
	bet_amountred = $("#amountred").val();
	bet_amountblack = $("#amountblack").val();
	$('#amountgreen').val('');
	$('#amountred').val('');
	$('#amountblack').val('');

	if(user_coins >= bet_amountgreen && user_coins >= bet_amountred && user_coins >= bet_amountblack ) {
		if(active == false) {
		active = true;
		var result = getResult();
		/*changeButton(result);*/
		window.setTimeout(restorebutton,2000);
		}

	}else{
		alert("NOT ENOUGH COINS");
	}
});

function getResult() {
var number = Math.floor(Math.random() * (14 - 0 +1)) + 0;
if(number == 0) {
	if (bet_amountgreen > 0) {
		user_coins = parseInt(user_coins) + parseInt((bet_amountgreen*14));
		updateCoins();
	}
	if (bet_amountred > 0) {
		user_coins = parseInt(user_coins) - parseInt(bet_amountred);
		updateCoins();
	}
	if (bet_amountblack > 0) {
		user_coins = parseInt(user_coins) - parseInt(bet_amountblack);
		updateCoins();
	}
	return greenme();
}
if(number > 0 && number <= 7) {
	if (bet_amountgreen > 0) {
		user_coins = parseInt(user_coins) - parseInt(bet_amountgreen);
		updateCoins();
	}
	if (bet_amountred > 0) {
		user_coins = parseInt(user_coins) + parseInt(bet_amountred);
		updateCoins();
	}
	if (bet_amountblack > 0) {
		user_coins = parseInt(user_coins) - parseInt(bet_amountblack);
		updateCoins();
	}
	return redme();
}
if(number > 7 && number <= 14) {
	if (bet_amountgreen > 0) {
		user_coins = parseInt(user_coins) - parseInt(bet_amountgreen);
		updateCoins();
	}
	if (bet_amountred > 0) {
		user_coins = parseInt(user_coins) - parseInt(bet_amountred);
		updateCoins();
	}
	if (bet_amountblack > 0) {
		user_coins = parseInt(user_coins) + parseInt(bet_amountblack);
		updateCoins();
	}
	return blackme();
}
}

function greenme(){
	$('.button').removeClass().addClass('animationgreen').addClass('button');
	$(".button").text("Green")
}
function redme(){
	$('.button').removeClass().addClass('animationred').addClass('button');
	$(".button").text("Red")
}
function blackme(){
	$('.button').removeClass().addClass('animationblack').addClass('button');
	$(".button").text("Black")
}

/*
function changeButton(array) {
	$(".button").text(array[0]);
	$(".button").css("background",array[1]);
	$(".button").css("border-color",array[1]);
}*/
function restorebutton() {
	$(".button").text("ROLL");
	$('.button').removeClass().addClass('restoreani').addClass('button');
	$(".button").css("border-color","#000");

	active = false;
}

window.setInterval(function(){
  updateCoins();
}, 1000);

$(document).ready(function(){
	var old_coins = parseInt(getCookie("coins")); // NAN7
	if(old_coins > 0) {
		user_coins = parseInt(old_coins);
		updateCoins();
	}else {
		user_coins = 50;
	}
});

function updateCoins() {
		$("#coins").html("coins: "+user_coins);
		var d = new Date();
		d.setTime(d.getTime() + (10*24*60*60*1000));
		var expires = "expires="+ d.toUTCString();
		document.cookie = "coins=" + user_coins + ";" + expires;
		user_coins = user_coins;

		//console.log("updated balance. Cookie saved at "+user_coins);
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


	/*var counter = setInterval(function() {
		console.log("hej");
	},500);
	*/

</script>


</body>
</html>
