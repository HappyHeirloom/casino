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

  <link rel="stylesheet" type="text/css" href="coinstyle.css"/>
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
  <link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
  <script src="js/modernizr.js"></script> <!-- Modernizr -->
</head>
<body>
	<h1>Hi, <b><?php echo $_SESSION['username'] ?></b> </h1>
	<h1 class="rainbow-text" style="color:white; font-size:50px; text-align:center; padding-top:50px;"> Coinflip </h1>
<-- git test-->
	<div class="bigwrapper">
		<div class="coinbetwrap">
			<div class="coins" id="coins">
			</div>
			<input type="integer" id="amounthead" placeholder="Enter your bet on HEADS" value="0" />
			<input type="integer" id="amounttail" placeholder="Enter your bet on TAILS " value="0" />
		</div>

		<div class="wrapper">
			<a href="#"><div class="button restoreani" id="start_game">
			ROLL
			</div></a>
		</div>
		<button id="clear"> clear history </button>
		<!-- <button id="autoscroll"> Toggle Autoscroll </button> -->
		<div id="history" class="history">
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
  			<li><a href="./roulette.php"><span>Roulette</span></a></li>
  			<li><a href="./coin.php" class="active"><span>Coin flip</span></a></li>
  			<li><a href="./wheel.php"><span>Shop</span></a></li>
  			<!-- <li><a href="#0"><span>Contact</span></a></li> -->
  		</ul>

  		<span aria-hidden="true" class="stretchy-nav-bg"></span>
  	</nav>
  </header>


	<script src="js/jquery-2.1.4.js"></script>
	<script src="js/main.js"></script> <!-- Resource jQuery -->

<script>
var bet_amounthead;
var bet_amounttail;
var user_coins = parseInt(50);

$("#coins").html("coins: "+parseInt(user_coins));

$(document).ready(function(){
	var old_coins = parseInt(getCookie("coins")); // NAN7
	if(old_coins > 0) {
		user_coins = parseInt(old_coins);
		updateCoins();
	}else {
		user_coins = 50;
	}
});

$("#start_game").on("click",function() {
	bet_amounthead = $("#amounthead").val();
	bet_amounttail = $("#amounttail").val();
	if(bet_amounthead <= user_coins) {
		if(bet_amounttail <= user_coins){
		flipCoin();
	}}else{
		alert("NOT ENOUGH COINS");
	}
});

function flipCoin(bet_amount) {
	bet_amounthead = $("#amounthead").val();
	bet_amounttail = $("#amounttail").val();
	if (Math.random() >= 0.5) { //heads
		if(bet_amounttail >= 0){
			user_coins -= parseInt(bet_amounttail);
			user_coins += parseInt(bet_amounthead);
			logMatch("WIN", bet_amounthead);
			logMatch("LOST", bet_amounttail);
			updateCoins();
		}else {
			user_coins += parseInt(bet_amounthead);
			updateCoins();
			logMatch("WIN", bet_amounthead);
		}
	}else { // tails
		if(bet_amounthead >= 0){
			user_coins += parseInt(bet_amounttail);
			user_coins -= parseInt(bet_amounthead);
			updateCoins();
			logMatch("WIN", bet_amounttail)
			logMatch("LOST", bet_amounthead);
		}else{
			user_coins -= parseInt(bet_amounthead);
			updateCoins();
			logMatch("WIN", bet_amounttail)
		}
	}
}

/*
function winCoins(bet_amount) {
}

function subtractCoins(bet_amount) {
}
*/

function logMatch(result,bet_amount) {
	var row = "<b>"+result+"</b> "+bet_amount+" coins! ("+user_coins+") <br/>";
	var soup = $("#history").html();
	$("#history").html(soup+row);
}

$("#clear").on("click", function(){
	$("#history").html("");
});

/* $("#autoscroll").on("click", function() {
	var autoscroll;
	if(autoscroll == true){
		window.setInterval(function(){
			$("div").scrollTop($("div").children().height());
		}, 1000000000000);
		autoscroll = false;
	}else{
		window.setInterval(function(){
			$("div").scrollTop($("div").children().height());
		}, 1);
	}
	autoscroll = true;
});
*/

/* ------------ Cookie ------------ */
window.setInterval(function(){
  updateCoins();
}, 1000);

function updateCoins() {
		$("#coins").html("coins: "+parseInt(user_coins));
		var d = new Date();
		d.setTime(d.getTime() + (10*24*60*60*1000));
		var expires = "expires="+ d.toUTCString();
		document.cookie = "coins=" + parseInt(user_coins) + ";" + expires;
		user_coins = parseInt(user_coins);

		/* console.log("updated balance. Cookie saved at "+user_coins); */
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

</script>

</body>
</html>
