<?php

namespace Detail\FileConversion\Processing\Adapter\Internal;

use Detail\FileConversion\Client\Job\JobBuilderInterface;
use Detail\FileConversion\Processing\Task;

interface InternalJobCreatorInterface
{
    /**
     * @param Task\TaskInterface $task
     * @param JobBuilderInterface $jobBuilder
     * @return \Detail\FileConversion\Client\Job\Definition\JobDefinitionInterface
     */
    public function create(Task\TaskInterface $task, JobBuilderInterface $jobBuilder);

    /**
     * Extract task's actions.
     *
     * @param Task\TaskInterface $task
     * @return string[]
     */
    public function getActions(Task\TaskInterface $task);

    /**
     * Extract task's actions with their respective params.
     *
     * @param Task\TaskInterface $task
     * @return array
     */
    public function getActionParams(Task\TaskInterface $task);
}
