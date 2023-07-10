<?php

namespace App\Services;

use Exception;
use App\Helpers\SettingHelper;

class AWSService
{
    private int $ATTEMPT_COUNT = 10;
    private int $WAIT_TIME = 5;

    /**
     * Get AWS EC2 Instance Status
     *
     * @param string $instance_id Instance ID
     * @return void
     */
    public function isInstanceRunning(string $instance_id): bool
    {
        $output = $this->executeCommand(
            "aws ec2 describe-instance-status --instance-ids \"{$instance_id}\"",
            true,
            'EC2 Instance ID is Invalid.'
        );

        return count($output['InstanceStatuses']) > 0;
    }

    public function startInstance(string $instance_id): void
    {
        if ($this->isInstanceRunning($instance_id)) {
            throw new Exception('This Instance is Already Started.');
        }

        $this->executeCommand("aws ec2 start-instances --instance-ids \"{$instance_id}\"", true);

        $count = 0;
        $isInstanceRunning = false;

        while ($count < $this->ATTEMPT_COUNT) {
            $isInstanceRunning = $this->isInstanceRunning($instance_id);

            if ($isInstanceRunning) {
                break;
            }

            sleep($this->WAIT_TIME);

            $count++;
        }

        if (!$isInstanceRunning) {
            throw new Exception('Failed to Start Instance.');
        }
    }

    public function stopInstance(string $instance_id): void
    {
        if (!$this->isInstanceRunning($instance_id)) {
            throw new Exception('This Instance is Already Stopped.');
        }

        $this->executeCommand("aws ec2 stop-instances --instance-ids \"{$instance_id}\"", true);

        $count = 0;
        $isInstanceRunning = true;

        while ($count < $this->ATTEMPT_COUNT) {
            $isInstanceRunning = $this->isInstanceRunning($instance_id);

            if (!$isInstanceRunning) {
                break;
            }

            sleep($this->WAIT_TIME);

            $count++;
        }

        if ($isInstanceRunning) {
            throw new Exception('Failed to Stop Instance.');
        }
    }

    public function getInstanceIPAddress(string $instance_id): string
    {
        if (!$this->isInstanceRunning($instance_id)) {
            throw new Exception('This Instance is not Started.');
        }

        $output = $this->executeCommand(
            "aws ec2 describe-instances --instance-ids \"{$instance_id}\" --query 'Reservations[].Instances[].PublicIpAddress' --output text"
        );

        return $output;
    }

    /**
     * Execute Command
     *
     * @param string $command Command
     * @param string $exception_message Exception Message
     * @return string | array Output
     */
    private function executeCommand(string $command, bool $is_output_array = false, string $exception_message = '')
    {
        $this->setSettings();

        exec($command, $output);

        if (!$is_output_array) {
            return $output[0];
        }

        if (count($output) === 0) {
            throw new Exception($exception_message ?? 'Command is Invalid.');
        }

        $output_json = str_replace(' ', '', implode('', $output));

        return json_decode($output_json, true);
    }

    /**
     * Set AWS Settings
     *
     * @return void
     */
    private function setSettings(): void
    {
        putenv('AWS_DEFAULT_REGION=' . SettingHelper::getSettingValue('AWS_DEFAULT_REGION'));
        putenv('AWS_ACCESS_KEY_ID=' . SettingHelper::getSettingValue('AWS_ACCESS_KEY_ID'));
        putenv('AWS_SECRET_ACCESS_KEY=' . SettingHelper::getSettingValue('AWS_SECRET_ACCESS_KEY'));
    }
}
