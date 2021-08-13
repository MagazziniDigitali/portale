<?PHP

// LOG_ALL 	All levels including custom levels.
// LOG_DEBUG 	Designates fine-grained informational events that are most useful to debug an application.
// LOG_INFO 	Designates informational messages that highlight the progress of the application at coarse-grained level.
// LOG_WARN 	Designates potentially harmful situations.
// LOG_ERROR 	Designates error events that might still allow the application to continue running.
// LOG_FATAL 	Designates very severe error events that will presumably lead the application to abort.
// LOG_OFF 	The highest possible rank and is intended to turn off logging.
// LOG_TRACE 	Designates finer-grained informational events than the DEBUG.

$WH_LOG_ALL 	= 6;
$WH_LOG_DEBUG	= 5;
$WH_LOG_INFO	= 4;
$WH_LOG_WARN	= 3;
$WH_LOG_ERROR	= 2;
$WH_LOG_FATAL	= 1;
$WH_LOG_OFF		= 0;

$WH_LOGGING_LEVEL = $WH_LOG_ALL; // DEFAULT

$LOG_LEVEL_MSG = array (
    $WH_LOG_ALL  => "->ALL: ",
    $WH_LOG_DEBUG => "->DEBUG: ",
    $WH_LOG_INFO => "->INFO: ",
    $WH_LOG_WARN => "->WARN: ",
    $WH_LOG_ERROR => "->ERROR: ",
    $WH_LOG_FATAL => "->FATAL: ",
    $WH_LOG_OFF => "->OFF: ",
);
// $LOG_LEVEL_MSG = array (
//     "->ALL: ",
//     "->DEBUG: ",
//     "->INFO: ",
//     "->WARN: ",
//     "->ERROR: ",
//     "->FATAL: ",
//     "->INFO: ",
// );


function wh_log($log_level, $log_msg)
{
    global $WH_LOGGING_LEVEL, $LOG_LEVEL_MSG;
	if ($log_level > $WH_LOGGING_LEVEL)
		return;



    $log_filename = "import.log";
    if (!file_exists($log_filename)) 
    {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
    // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
    file_put_contents($log_file_data, $LOG_LEVEL_MSG[intval($log_level)] . date('d-M-Y h:i:s') . " + " . $log_msg . "\n", FILE_APPEND); //  
} 

function wh_set_log_level($log_level)
{
    global $WH_LOGGING_LEVEL, $WH_LOG_ALL;
    if ($log_level < 1 || $log_level > $WH_LOG_ALL)
        $WH_LOGGING_LEVEL = $WH_LOG_ALL;
    else
    $WH_LOGGING_LEVEL = $log_level;

}

// TESTS
// wh_set_log_level($WH_LOG_DEBUG);
// 
// wh_log($WH_LOG_DEBUG, "Message 2");
// wh_log($WH_LOG_INFO, "Message 2");
// wh_log($WH_LOG_WARN, "Message 2");
// wh_log($WH_LOG_ERROR, "Message 2");
// wh_log($WH_LOG_FATAL, "Message 2");
// wh_log($WH_LOG_OFF, "Message 2");

?>



