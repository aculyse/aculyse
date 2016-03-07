<?php

namespace Aculyse\Loggers;

use Aculyse\Models\AccessLog;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Aculyse\Traits\Eloquent;
use Aculyse\Models\ActivityLog;
use Aculyse\Helpers\Auth\ActiveSession;

class Log extends AbstractProcessingHandler
{

    private $logger;
    public $level = Logger::DEBUG;
    public $bubble = true;
    public $log_path;

    use Eloquent;

    public function __construct()
    {
        $this->startEloquent();
        $this->logger = new Logger('user');
        $this->log_path = dirname(dirname(dirname(__DIR__))) . '/logs/access.log';
        parent::__construct($this->level, $this->bubble);
    }

    public function write(array $records)
    {
        $ActivityLog = new ActivityLog();
        $ActivityLog->user = ActiveSession::id();
        $ActivityLog->activity_type = $records["activity"];
        $ActivityLog->table = $records["table"];
        $ActivityLog->description = $records["description"];
        $ActivityLog->browser = $_SERVER['HTTP_USER_AGENT'];
        $ActivityLog->ip_address = $_SERVER['REMOTE_ADDR'];
        return $ActivityLog->save();
    }

    public function access($type)
    {
        $AccessLog = new AccessLog();
        $AccessLog->user = ActiveSession::id();
        $AccessLog->message = $type;
        $AccessLog->browser = $_SERVER['HTTP_USER_AGENT'];
        $AccessLog->ip_address = $_SERVER['REMOTE_ADDR'];
        return $AccessLog->save();
    }

    public function put($message)
    {
        // Now add some handlers
        $this->logger->pushHandler(new StreamHandler($this->log_path, Logger::DEBUG));
        $this->logger->pushHandler(new FirePHPHandler());
        $this->logger->addInfo($message);
    }

}
