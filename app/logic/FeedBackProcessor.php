<?php

/**
 * @author Blessing Mashoko <projects@bmashoko.com>
 * Manage user feedback
 */

namespace Aculyse;
    
    
require_once dirname(dirname(__DIR__))."/vendor/autoload.php";
    use Aculyse\Traits\DBConnection;
    use Aculyse\Helpers\Auth\ActiveSession;

    class FeedBackProcessor
    {
        use DBConnection;
        public $newConnection , $con , $dataset = array() ;

        public function __construct()
        {
            $this->con = $this->databaseInstance();
                $this->user_id = ActiveSession::id() ;
                $this->auth_school_id = ActiveSession::school() ;
        }

        public function saveFeedback( $description , $url )
        {
            $this->description = mysqli_real_escape_string($this->con , $description) ;
            $this->url = mysqli_real_escape_string($this->con , $url) ;
            $this->browser = mysqli_real_escape_string($this->con , $_SERVER["HTTP_USER_AGENT"]) ;

            $this->sql = "INSERT INTO `feedback`(`user`, `description`, `url`,browser) VALUES ('$this->user_id','$this->description','$this->url','$this->browser') " ;

            $this->executeQuery = mysqli_query($this->con , $this->sql) ;

            if(!$this->executeQuery) {
                return "SQLExecutionExecption" ;
            }
            if(mysqli_affected_rows($this->con) >= 0) {
                return "success" ;
            }
            else {
                return "failed" ;
            }
        }
}
