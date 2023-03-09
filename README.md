Assumptions
===========
* All incoming data has been sanitised

* It doesn't matter which employee visits which site

* Check ins can take place at weekends, and at any time

* A maximum of one student can be checked in by one employee at a time

* Check in visits take one hour

* Check in dummy data gathered from https://www.mockaroo.com/


Running Code
============

* Place your CSV file in \data, and set the CSV_FILE constant in index.php

* Send a GET request to index.php to receive CSV data of checkins. Data contains the fields: 

tenant_id 		Unique tenant ID taken from the CSV data
employee_id	    Unique employee ID, only if satisfied is TRUE
satisfied		TRUE or FALSE indicating whether the requested checkin time satisfied the rules
message		    Text error message, only if satisfied is FALSE

* Tests require PHPUnit to be installed. A composer.json file is included to enable Composer to perform the installation.

* All tests can be found in \tests and run with PHPUnit


Future Expansions
=================

* $CheckInReport->checkInReport() performs two functions, but I didn't want to over-engineer the code prematurely. This function could be separated into two parts, the data parsing and report creation. 

* Data parsing would be a more complex process, involving permanent storage. Users should be able to send CSV data through the API.

* The CheckIn class contains hardcoded rules of acceptable checkins (e.g. no checkins on the last of the month) could be enhanced into a user interface allowing for the creation of custom rules.

* Report creation could then be separated into several endpoints, allowing for other reports to be generated. For example, reports specific to individiual employees or properties. Historical data can be reported on too, for example checkins per month or year.

* Constants used (e.g. TRAVEL_TIME_MINUTES) could be requested as part of the API call