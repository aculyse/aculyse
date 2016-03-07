<?php

namespace Aculyse\Guardian\Auth;

use Aculyse\AccessLevels;
use Aculyse\AccessManager;
use Aculyse\Models\Guardian;
use Aculyse\Models\GuardianInvitation;
use Aculyse\Traits\Eloquent;
use Illuminate\Hashing\BcryptHasher;

class Auth
{
    use Eloquent;

    /**
     * Hashing Object
     * @var BcryptHasher
     */
    private $Hasher;

    /**
     * Current user
     * @var user
     */
    private $user;

    public function __construct()
    {
        $this->Hasher = new BcryptHasher();
        $this->startEloquent();
    }

    /**
     * Check if user credentials are correct
     * @param $username
     * @param $password
     * @return bool
     */
    private function checkCredentials($username, $password)
    {
        $this->user = Guardian::where("email", $username)
            ->orWhere("phone", $username)
            ->first();

        if (is_null($this->user)) {
            return FALSE;
        }
        return $this->Hasher->check($password, $this->user->password);
    }


    /**
     * Login user
     * @param $email
     * @param $password
     * @return bool|TRUE
     */
    public function login($email, $password)
    {

        if (!$this->checkCredentials($email, $password)) {
            return FALSE;
        }
        return AccessManager::startSession($this->user->name, AccessLevels::LEVEL_GUARDIAN, null, $this->user->id, []);

    }

    /**
     * Check if the invitation credentials are correct
     * @param $guardian_contact
     * @param $invitation_code
     * @return mixed
     */
    public function isInvitationValid($guardian_contact, $invitation_code)
    {

        $status = GuardianInvitation::where("email", $guardian_contact)
            ->orWhere("phone", $guardian_contact)
            ->where("invitation_code", $invitation_code)
            ->get();

        return $status;
    }


    /**
     * Create guardian account
     * @param $email
     * @param $phone
     * @param $name
     * @param $password
     * @return bool
     */
    public function createAccount($email, $phone, $name, $password)
    {
        $guardian = new Guardian();
        $guardian->email = $email;
        $guardian->name = $name;
        $guardian->password = $this->Hasher->make($password);
        $guardian->phone = $phone;
        return $guardian->save();
    }


    public function changePassword($user_id,$new_password){

        $new_password = $this->Hasher->make($new_password);
        $user = Guardian::find($user_id);
        $user->password = $new_password;
        return $user->save();
    }

}
