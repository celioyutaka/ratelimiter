<?php
set_time_limit(0);
require_once('ratelimiter.php');


echo 'IMPORTANT, ALLOW WRITE PERMISSION<BR>';


echo "<H1>EXAMPLE 1</H1><br>";
$init = microtime(true);
$check = $init;
for ($i=1; $i <= 10; $i++) { 

	$rate = ratelimiter(8, 1, false, 'example1');
	echo 'Count: '.$i.'<br>';

	$delta = microtime(true) - $check;
	$check = microtime(true);
	$time_passed = $check-$init;
	echo "Time passed: {$time_passed}<br>Delta Time: {$delta}<br><br>";
	while(!ratelimiter(8, 1, true, 'example1')){
		//DO SOMETHING, LIKE usleep();
		usleep(1 * 1000000);

	}


	
}

/// example 2
echo "<br><H1>EXAMPLE 2</H1><br>";

for ($i=1; $i <= 10; $i++) { 
	if (ratelimiter(8, 1, false, 'example2')){
		echo "<br>$i - REQUEST DONE";
	}
	else{
		ECHO "<br>$i - ERROR - Rate Limit";
	}	
}


echo "<br><H1>EXAMPLE 3 - DOUBLE (AND) RATE LIMIT</H1><br>";

for ($i=1; $i <= 10; $i++) {
	if (ratelimiter(10, 2) && ratelimiter(15, 1)){
		
		//IMPORTANT - IN PHP, IF FIRST ratelimiter() IS FALSE THE SECOND CALL OF ratelimiter() WILL NOT BE CALLED
		
		echo "<br>$i - REQUEST DONE<br>";
	}
	
	else{
		ECHO "<br>$i - ERROR - Rate Limit<br>";
	}
}


echo "<br><H1>EXAMPLE 4 - DOUBLE (OR) RATE LIMIT</H1><br>";

for ($i=1; $i <= 10; $i++) {
	$rate1 = ratelimiter(5, 1);
	$rate2 = ratelimiter(30, 2);
	if ($rate1 or $rate2){
		/*
			IMPORTANT - IN PHP, IF FIRST ratelimiter() IS FALSE THE SECOND CALL OF ratelimiter() WILL NOT BE CALLED
		*/
		echo "<br>$i - REQUEST DONE<br>";
	}
	
	else{
		ECHO "<br>$i - ERROR - Rate Limit<br>";
	}
}