<?php


namespace Aculyse\Traits;

use Aculyse\Helpers\Auth\ActiveSession;
use Aculyse\Models\Student;
use Aculyse\Models\GuardianInvitation;
use Carbon\Carbon;
use Aculyse\Mail\Mail;

/**
* This traits allows guardians to be invited to create accounts.
 *
* This trait should be used in presents of eloquentORM.
*/
trait GuardianInvitable{

  /**
   * Get a list of guardians that can be invited
   * to join the platform
   * @return mixed
   */
  public function getInvitable(){
    $students = Student::where("status","!=","deleted")
            ->where("status","!=","graduated")
            ->where("status","!=","transfered")
            ->where("status","!=","deactivated")
            ->whereRaw("email !=?  || `cell number` !=?",['',''])
            ->get();

    return $students;
  }

  /**
   * Send Invitations to users
   * @param $student_list
   */
  public function invite($student_list){
    $invitation = new GuardianInvitation();

    foreach ($student_list as $student) {
      $inv_code = rand(100000,999999);
      $invitation->student_id = $student->id;
      $invitation->invitation_code = $inv_code;
      $invitation->email = $student->email;
      $invitation->phone = $student["cell number"];
      $invitation->invitation_key = sha1(Carbon::now());

      $this->sendMail($inv_code);
      $invitation->save();
    }
    return;
  }

  public function sendMail($inv_code){
    $mail = new Mail();
    $mail->heading="Track your child's perfomance with Aculyse";
    $mail->message="
    <div
    style='background:#dbe6ec;font-family: Roboto,Droid Sans,sans-serif,Arial, Verdana;text-align: left; padding: 2%;'>
    <div style='background:#0074a2;padding: -2%;'>
    <h1 style='padding: 2%;font-weight: bold; color:#fff;font-size: 40px;'><span>acu</span><span style='color: orange;'>lyse</span></h1>
    </div>
    You are invited by ".ActiveSession::schoolName()." to signup for the service and have the convenience of tracking
    your child's perfomance in real time. 24/7 365 days.<br/><br/>
    To get started click <a href='".GUARDIAN_HOME_URL."/invitation'>here</a><br/>
    If you cannot click the link visit this url <b>".GUARDIAN_HOME_URL."/invitation</b>
    Your invitation code is <br/><span style='font-size:30px;font-weight:bold'>$inv_code</span><br/><br/><br/>

    <b>Team Aculyse</b><br/>
<br/>
    <small>Aculyse is a platform analysing and reporting on student perfomance. For more information email support@aculyse.com</small><br/>
    </div>";

    $mail->recipient= "newuser@localhost";
    $mail->send();

  }


}
