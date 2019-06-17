# Rate Limiter
Rate Limiter - X Requests per Y Seconds - Server Side

## HOW TO USE
IMPORTANT, ALLOW WRITE PERMISSION

### Simple Example
```
<?php
require_once('ratelimiter.php');
//...

function getFromAPI(){
	if (ratelimiter(8, 1)){//8 REQUESTS PER SECOND
		return file_get_contents("API_LINK");
	}
	else{
		return false;
	}
}
```

### Test Example
```
<?php
require_once('ratelimiter.php');

for ($i=1; $i <= 10; $i++) { 
	if (ratelimiter(8, 1)){//8 REQUESTS PER SECOND
		echo "$i - REQUEST DONE";
	}
	else{
		echo "$i - ERROR - Rate Limit";
	}	
}
```


### Sleep Example - (Wait Example)
```
<?php
require_once('ratelimiter.php');

for ($i=1; $i <= 10; $i++) { 
	$rate = ratelimiter(7, 1, false);
	while(!ratelimiter(7, 1, true)){//ONLY VERIFY
		usleep(1 * 1000000);
	}
}
```

### MULTIPLE RATE-LIMITS
```
<?php
require_once('ratelimiter.php');

for ($i=1; $i <= 10; $i++) {
	if (ratelimiter(5, 1, false, 'apple')){
		echo 'Eat apple';
	}
	else
	{
		echo 'Error - apple';
	}

	if (ratelimiter(5, 1, false, 'orange')){
		echo 'Eat orange';
	}
	else
	{
		echo 'Error - orange';
	}
}
```


### CHECK IF HAS ALLOWANCE
```
<?php
require_once('ratelimiter.php');

for ($i=1; $i <= 5; $i++) {
	if (ratelimiter(10, 1)){
		echo 'Foo';
	}
	else
	{
		echo 'Error';
	}
}
var_dump(ratelimiter(10, 1, true));
//return true
```

### NOTES
The function parameters define the file name. Examples:

**ratelimiter(3, 2)**
- request_allowance__**3_2**.dat
- request_lastcheck__**3_2**.dat

**ratelimiter(10, 1)**
- request_allowance__**10_1**.dat
- request_lastcheck__**10_1**.dat

**ratelimiter(10, 1, false, 'CUSTOM_NAME')**
- request_allowance_**CUSTOM_NAME_10_1**.dat
- request_lastcheck_**CUSTOM_NAME_10_1**.dat



## Donation
[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3LFNY252324HC&source=url)
