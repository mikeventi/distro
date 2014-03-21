<?php

require('GroupEmail.class.php');
require_once("../mail/Mail.php");


function emailGarageReport($driver,$manrecipient="")

    {


    $body = file_get_contents ('messages/GarageTemplate.html');
    $carHTML = "";

    $db = new VulcanMotorClubDB();
        $cars = $db->getCarsAvailThisWeekend();

    if ($cars) {

        $count=0;
          foreach ($cars as $record)
          {

         if (($count % 2) == 0)
            {

    $carHTML .= '<TR><TD width=25>&nbsp;</TD>'
        . '<TD>'
        . '<A href="https://www.vulcanmotorclub.com/members/login.php?username=$emailaddress" style="text-decoration: none; color: #FFFFFF;"><img border=0 width="297" height="128" src="http://www.vulcanmotorclub.com/_uploads/_images/_splash/' . $record->splash_small_filename . '" alt="' . $record->make . ' ' . $record->model . '" /></a>' . "\n"
        . '<img width="297" src="http://www.vulcanmotorclub.com/_images/MemberCenter/dashline.gif">'. "\n"
        . '<table width="300"><TR><TD style="font-weight: bold; font-size: 14px; color: rgb(255,255,255);">' . $record->make . ' <span style="font-weight: bold; font-size: 16px; color: rgb(173,188,197);">' . $record->model . '</span></TD>'. "\n"
        . '<TD align=right style="font-weight: normal; font-size: 12px; color: rgb(255,255,255);"><A href="https://www.vulcanmotorclub.com/members/login.php?username=$emailaddress" style="text-decoration: none; color: #FFFFFF;">reserve &gt;&gt;</A></TD></TR></table>'. "\n"
        . '</td>'. "\n" ;


            }
        else{

$carHTML .= '<TD>'
        . '<A href="https://www.vulcanmotorclub.com/members/login.php?username=$emailaddress" style="text-decoration: none; color: #FFFFFF;"><img border=0 width="297" height="128" src="http://www.vulcanmotorclub.com/_uploads/_images/_splash/' . $record->splash_small_filename . '" alt="' . $record->make . ' ' . $record->model . '" /></a>' . "\n"
        . '<img width="297" src="http://www.vulcanmotorclub.com/_images/MemberCenter/dashline.gif">'. "\n"
        . '<table width="297"><TR><TD style="font-weight: bold; font-size: 14px; color: rgb(255,255,255);">' . $record->make . ' <span style="font-weight: bold; font-size: 16px; color: rgb(173,188,197);">' . $record->model . '</span></TD>'. "\n"
        . '<TD align=right style="font-weight: normal; font-size: 12px; color: rgb(255,255,255);"><A href="https://www.vulcanmotorclub.com/members/login.php?username=$emailaddress" style="text-decoration: none; color: #FFFFFF;">reserve &gt;&gt;</A></TD></TR></table>'. "\n"
        . '</td></TR>'. "\n" ;

        }


        $count++;
          }
    } else {
        echo 'No can do. Either no cars are available, or it is a Saturday/Sunday.';
    }


//  print_r($body);

    $from = $driver->managername . " <" . $driver->manageremail. ">";
    $subject = "The Vulcan Garage: " . date("l, M d, Y"); //. " ( debug to: " . $driver->email . ")";


    // if something barfed then cancel
    if (!$body) {return;}

    // hack until the site goes live
    if ($manrecipient) {
        $to = $manrecipient;

    } else {
//      $to = "Aaron Fessler <aaron@vulcanmotorclub.com>";
        $to = $driver->firstname . ' ' . $driver->lastname . ' <' . $driver->email . '>';
    }

    $body = str_replace('$availablecars',$carHTML,$body);
    $body = str_replace('$fullname',$driver->firstname . ' ' . $driver->lastname,$body);
    $body = str_replace('$firstname',$driver->firstname,$body);
    $body = str_replace('$lastname',$driver->lastname,$body);
    $body = str_replace('$availdays',$driver->AvailDays,$body);
    $body = str_replace('$availmiles',$driver->AvailMiles,$body);
    $body = str_replace('$emailaddress',$driver->email,$body);


    //$this->logInfo('Sent garage report to ' . $to);


    SendMessage($to, $from, "", $subject, $body);

    }


?>

<html>
<body>

</body>
</html>