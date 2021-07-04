<?php
/************************************
********controller for webapi********
*******webapi only receives data*****
****from web applications and *******
***returns json strings if at all****
***authentication is realized via****
*****an api token which will be *****
****passed by the application******** 
************************************/

class Controller {
/*
* var 
*/
private $model;
private $input = array();

/**
* constructor
* @param input array()
*/

public function __construct($input) {
$this->model = new WebApiModel();
$token = null;
//check authentication
if (isset($_SESSION['token']) ) {
	$token = $_SESSION['token']; 
	} else if (isset($input['tkn'])) {
	$token = $input['tkn'];
	} else {
	$return = array("message" => "authentication failed!"); //message should stay like that - is checked upon in SusoVP software!
	$this->sendStatusMessage($return);
	}
if ($this->checkTokenAuth($token) ) {
	$this->handleInput($input);
    } else {
        $return = array("message" => "authentication failed!");
        $this->sendStatusMessage($return);
    }

}

/**
* handle inputs
* @param string
*/
private function handleInput($input) {
$return = null;
if (isset($input['type']) ) {
    switch ($input['type']) {
        case "event":
			if(isset($input['eventdata'])) {
            $this->model->writeLog('api_access.log',' events updated.');
			$return = $this->updateEvents($input['eventdata']);
			} else {
			$return = array("message" => "no data");
			}
            break;
        case "usrchk":
            //check for all invalid users, i.e. user without children or user without verification (not yet in use)
            $msg = $this->checkUsersAndAct();
            $this->model->writeLog('api_access.log',' check for inactive users.');
            $return = array("message" => $msg);
            break;
        case "vp":
            //$this->model->writeLog('api_access.log',' called from SusoVP: ' . $input['vpdata']);
            //Now work with this data
            $actionMessage = $this->handleCoverLessonTransaction($input['vpdata']);
            $return = array("message" => $actionMessage);
            break;
        default:
            $return = array("message" => "nothing to do");
            break;
        }
		
    } else {
        $return = array("message" => "nothing to do");
        

    }
$this->sendStatusMessage($return);

}

/**
* check authentication
* @param token string
* @return boolean
*/
private function checkTokenAuth($token) {
    $customer = $this->model->checkTokenAuth($token);
    return ($customer != null) ? true : false;
	}

/**
 * enter data for cover lessons
 * @param string
 * @return string
 */
private function handleCoverLessonTransaction($coverLessonData) {
    $dataToWorkWith = explode("=",$coverLessonData);
    $msg = "no action!";
    switch ($dataToWorkWith[0]){
        case "datum":
            //bereite DB vor für Einlesen der aktiven Vertretungen
            $msg = $this->model->prepareForEntry($dataToWorkWith[1]);
        break;
        case "absT":
            //Trage abwesende Lehrer ein
            $msg = $this->model->insertAbsentee($dataToWorkWith[1]);
        break;
        case "blockR":
            //Trage blockierte Räume ein
            $msg = $this->model->insertBlockedRoom($dataToWorkWith[1]);
        break;
        case "content":
            //Trage Vertretungsdaten ein
            $msg = $this->model->insertCoverLesson($dataToWorkWith[1]);
        break;
        case "mail":
            //Starte Mailversand
            $msg = $this->sendMails($this->model->getMailList());
            //Lösche entfernte Zeilen
            $this->model->DeleteInactiveEntries();
        break;
        default:
        break;

    }
    return $msg; //message sent back to SusoVPlan Software
    
    
}

/**
* update events
* @param string
*/
private function updateEvents($events) {
$eventArray = json_decode($events,true);
//var_dump($eventArray) ; //nur debugging
$this->model->addEventsToDB($eventArray);

//get all events from database

$this->createICS($this->model->getEvents(null));
$this->createICS($this->model->getEvents(null),null,true); //createMoodlePublic Events

$this->createICS($this->model->getEvents(true), true); //create StaffVersion
$this->createICS($this->model->getEvents(true), true, true); //create Moodle StaffVersion
$return = array("message" => "events updated");
return $return;
}



/**
     *Eintrag aller Termins in eine ics-Datei
     *
     * @param $file String Dateiname
     * @param $termine Array(Terminobjekt)
     */
    public function createICS($termine, $staff = null) {
        
		//this really should be reused from the class TManager but does not work
        $path = $this->model->getIniParams();
        $filebase = $path['icsfile'];
	$fileName = $staff ? $filebase . "Staff.ics" : $filebase . "Public.ics";
	$file = $path['filebase'] . $path['download'] . '/' . $fileName; //used to be path['basepath'];
       	$f = fopen($file, "w");
        fwrite($f, "BEGIN:VCALENDAR\r\n");
		$id = 1000;
        foreach ($termine as $t) {
			if ($staff || !$t->staff) {
                fwrite($f, "BEGIN:VEVENT\r\n");
                //if ($mail == true") {fwrite($f,'ATTENDEE;CN="Kollegium (lehrer@suso.schulen.konstanz.de)";RSVP=TRUE:mailto:lehrer@suso.schulen.konstanz.de');}

                $entryTextStart = "DTSTART:";
                $entryTextEnd = "DTEND:";
                if (strlen($t->start) < 9) {
                    //keine Zeitangabe, also ganztägiger Termin
                    $entryTextStart = "DTSTART;VALUE=DATE:";
                    $entryTextEnd = "DTEND;VALUE=DATE:";
                }
				fwrite($f, "UID:" . $t->id . "\r\n");
				fwrite($f, "DTSTAMP:" . $t->createTimeStamp . "\r\n");
                fwrite($f, $entryTextStart . $this->makeUTCTime($t->start) . "\r\n");
                fwrite($f, $entryTextEnd . $this->makeUTCTime($t->ende) . "\r\n");
                fwrite($f, "SUMMARY;LANGUAGE=de:" . $t->typ . "\r\n");
                /*fwrite($f,'X-ALT-DESC;FMTTYPE=text/html:<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">\n<HTML>\n
                    <HEAD>\n<TITLE></TITLE>\n</HEAD>\n<BODY>\n\n<P DIR=LTR><SPAN LANG="de"></SPAN></P>\n\n</BODY>'.$text.'</HTML>');
                */
                fwrite($f, "END:VEVENT\r\n");
            }
		$id++;
        }
        fwrite($f, "END:VCALENDAR");
        fclose($f);
    }


/**
* turn a timestring YYYYMMDDTHHMMSS into UTC Time
* @param string
*/
public function makeUTCTime($time){

//check if time is given
$timeArr = explode("T",$time);
if (!isset($timeArr[1]) ) {
return $time;
}


$datetime = $time;
$tz_from = 'Europe/Berlin';
$tz_to = 'UTC';
$format = 'Ymd\THis\Z';

$dt = new DateTime($datetime, new DateTimeZone($tz_from));
$dt->setTimeZone(new DateTimeZone($tz_to));
return $dt->format($format);

}


/**
 * checking for unused users
 * @return string
 */
private function checkUsersAndAct(){
    $users = $this->model->getUsersWithoutKids();
    $unconfirmedUsers = $this->model->getUsersWithoutConfirmedRegistration();
    //write actions to log
    $this->model->writeLog('usr_check.log',' checking for inactive users.');
    $this->model->writeLog('usr_check.log',count($users)." without registered kids!.");
    $i = 1;
    foreach ($users as $usr){
        $addon = "";
        if ($usr['todelete'] == true) {
            $addon = " -- WILL BE REMOVED!";
            $this->model->deleteUsers($usr['id'],$usr['eid']);
            }
    $line = $i." - User with ID ".$usr['id']."[eid = ".$usr['eid']."]: ".$usr['name'].", ".$usr['vorname'].
    " (".$usr['mail'].") - registriert am: ".$usr['registered'].$addon; 
    $this->model->writeLog('usr_check.log',$line);
    $i++;
    
    
    }
    $this->model->writeLog('usr_check.log', count($unconfirmedUsers)." without complete registration");
    $i = 1;
    foreach ($unconfirmedUsers as $usr){
    $line = $i." - User with ID ".$usr['id']."[eid = ".$usr['eid']."]: ".$usr['name'].", ".$usr['vorname']." (".$usr['mail'].") - registriert am: ".$usr['registered']; 
    $this->model->writeLog('usr_check.log',$line);
    $i++;
    $this->model->deleteUsers($usr['id'],$usr['eid']);
    }
    //trigger email report
    $this->sendWeeklyUserReport($users,$unconfirmedUsers,"phartleitner@hotmail.de");

    return "unused users detected and deleted. See log-file.";
}


/**
* sending status message to calling application
* @param array
*/
private function sendStatusMessage($msg) {
   die(json_encode($msg) );
}



/**
 * sending a weekly report to admin user 
 * reporting about users without a confirmed registration oer without kids
 * the report is triggered by a remote server cronjob
 * @param array users without kids
 * @param array users without confrimed registration
 * @param string
 */
private function sendWeeklyUserReport($users,$unconfirmedUsers,$email){
    require_once("../PHPMailer.php");
    $now = date("d.m.Y H:i:s");
    $text = "Your weekly report on Suso-Intern-User State, triggered at <b>".$now."</b> :<br/><br/><b>
    The following users have not registered kids, yet. They will be automatically removed after 60 days:</b><br/><br/>";
    $i = 1;
    foreach ($users as $usr){
        $addon = ($usr['todelete'] == true) ? " -- WILL BE REMOVED!" : "";
        $text .= $i." - User with ID ".$usr['id']."[eid = ".$usr['eid']."]: ".$usr['name'].", ".$usr['vorname'].
        " (".$usr['mail'].") - registriert am: ".$usr['registered'].$addon."<br/>"; 
        $i++;
    }
    $text .= '<br/><br/><b>The following users have not confirmed their registration for more than 24 hrs and will be removed: </b><br/><br/>';
    $i = 1;
    foreach ($unconfirmedUsers as $usr){
        $text .= $i." - User with ID ".$usr['id']."[eid = ".$usr['eid']."]: ".$usr['name'].", ".$usr['vorname']." (".$usr['mail'].") - registriert am: ".$usr['registered']."<br/>"; 
        $i++;
        }
    $content = $text;

    //sending emails
    $phpmail = new PHPMailer();
    $phpmail->setFrom("noreply@suso.konstanz.de", "Suso-Intern");
    $phpmail->CharSet = "UTF-8";
    $phpmail->isHTML();
    $phpmail->AddAddress($email);
    $phpmail->Subject = date('d.m.Y - H:i:s') . "Suso-Intern - weekly user-report";
    $phpmail->Body = $content;
        
    $send = true;
    
    //Senden
    if (!$phpmail->Send()) {
        $send = false;
    } 
    
    return $send;
}



   /**
     *
     *triggering email via phpmailer
     *
     * @param array () containing list of mail recipients (User object)
     */
    private function sendMails($list) {
        $currentTime = date('d.m.Y H:i:s');
        $this->model->writeToVpLog("Starting to send mails on " . $currentTime);
        require_once("../PHPMailer.php");
        //sending emails
        $timestamp = time();
        $datum = date("Y-m-d  H:i:s", $timestamp);
        /** @var Teacher $l */
        foreach ($list as $l) {
            /** @var PHPMailer $phpmail */
            $phpmail = new PHPMailer();
            $phpmail->setFrom("stundenplan@suso.konstanz.de", "Vertretungsplan Suso");
            $phpmail->CharSet = "UTF-8";
            $phpmail->isHTML();
            $phpmail->AddAddress($l->getEmail());
            $phpmail->Subject = date('d.m.Y - H:i:s') . " aktueller Vertretungsplan";
            $phpmail->Body = $this->model->makeHTMLVpMailContent($l);
            
            //Protokolldaten vorbereiten
            //Mailadressen der Instanz:
            $allmailstring = "";
            foreach ($phpmail->getAllRecipientAddresses() as $ema) {
                if ($allmailstring == "") {
                    $allmailstring = $ema[0];
                } else {
                    $allmailstring = $allmailstring . ';' . $ema[0];
                }
            }
            $cont = null;
            
            
            //Senden
            if (!$phpmail->Send()) {
                echo "cannot send!";
                //$mail[$x]->Send() liefert FALSE zurück: Es ist ein Fehler aufgetreten
                $currentTime = date('d.m.Y H:i:s');
                $this->model->writeToVpLog("....failure." . $phpmail->ErrorInfo . " Trying to reach " . $l->getEmail() . " " . $currentTime);
            } else {
                echo "mail gesendet an: " . $l->getEmail() . '<br>';
                //Eintrag des Sendeprotokolls
                $currentTime = date('d.m.Y H:i:s');
                $this->model->writeToVpLog($l->getEmail() . " " . $currentTime);
                
                //Inhalt
                //$this->model->writeToVpLog("....success");
            }
            
            
            //Trage email Versanddatum in DB ein
            foreach ($l->getCoverLessonNrs() as $cl) {
                $this->model->UpdateVpMailSentDate($cl);
            }
            
            $allmailstring = null;
            $cont = null;
        }
        $this->model->writeToVpLog("*****************************************************");
    }


}
?>
