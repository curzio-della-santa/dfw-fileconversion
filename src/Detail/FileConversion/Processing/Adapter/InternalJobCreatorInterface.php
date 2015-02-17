<?php

namespace Detail\FileConversion\Processing\Adapter;

use Detail\FileConversion\Client\Job\JobBuilderInterface;
use Detail\FileConversion\Processing\Task;

interface InternalJobCreatorInterface
{
    public function create(Task\TaskInterface $task, JobBuilderInterface $jobBuilder);
}