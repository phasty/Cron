<?php
namespace Phasty\Cron {
    class Manager {
        protected $appId = null;

        public function setAppId($appId) {
            $this->appId = $appId;
        }

        public function addTask($time, $task, $runId) {
            $cron = "$time $task " . $this->getTag($runId);
            exec("(crontab -l; echo '$cron') | crontab");
        }

        public function removeTask($runId) {
            $runId = preg_quote($this->getTag($runId));
            exec("crontab -l | grep -v '$runId' | crontab");
        }

        protected function getTag($runId) {
            if (!isset($this->appId)) {
                throw new \Exception("App id was no set");
            }
            return "#app-{$this->appId}/$runId";
        }
    }
}
