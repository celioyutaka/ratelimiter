<?php
/**
 * Rate Limiter
 *
 * This function check rate limiter, like X REQUESTS PER Y SECONDS
 * IMPORTANT, ALLOW WRITE PERMISSION
 *
 * @param int $rate Requests
 * @param int $per Per Seconds
 * @param bool $only_verify Don't decresces allowance, only checks
 * @param string $unique Unique name, when rate and per is equal but limiter is diferent
 *
 * @return bool TRUE -> IS ALLOWED, FALSE -> IS NOT ALLOWED
 * 
*/
function ratelimiter($rate = 10, $per = 1, $only_verify = false, $unique = ''){
	/*FILE TO SAVE/LOAD LAST CHECK AND ALLOWANCE*/
	$allowance_file = "request_allowance_{$unique}_{$rate}_{$per}.dat";
	$lastcheck_file = "request_lastcheck_{$unique}_{$rate}_{$per}.dat";

	if (file_exists($lastcheck_file)){
		$last_check = file_get_contents($lastcheck_file);
	}
	else{
		/*IF DOEST FILE EXISTS CREATE FILE - LAST CHECK WITH ACTUAL TIMESTAMP*/
		$last_check = microtime(true);
		file_put_contents($lastcheck_file, $last_check);
	}

	if (file_exists($allowance_file)){
		$allowance = file_get_contents($allowance_file);
	}
	else{
		/*IF DOEST FILE EXISTS CREATE FILE - RATE AS ALLOWANCE*/
		$allowance = $rate;
		file_put_contents($allowance_file, $rate);
	}

	$current = microtime(True);
    $seconds_passed = $current - $last_check;
    //echo "{$last_check}, {$seconds_passed}, {$allowance}<br>";

    if ($seconds_passed > $per){
    	/* IF PASSED TIME IS BIGGER THAN $per SECONDS, "RESET" ALLOWANCE */
    	$allowance = $rate;
    	if (!$only_verify){
    		$allowance --;
			file_put_contents($lastcheck_file, microtime(true));
    	}
		file_put_contents($allowance_file, $allowance);
    	return true;
    }
    else{
    	if ($allowance > 0){
    		/*IF ALLOWANCE IS BIGGER THAN 0 (ZERO), AND $only_verify IS FALSE, THAN DECREASE ALLOWANCE*/
    		if (!$only_verify){
    			$allowance --;
				file_put_contents($lastcheck_file, microtime(true));
    		}
			file_put_contents($allowance_file, $allowance);
    		return true;
    	}
    	else{
    		$allowance = 0;
    	}
    	return false;
    }
}