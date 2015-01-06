<?php

namespace Detail\FileConversion\Job;

interface JobBuilderInterface
{
    /**
     * @return Definition\JobDefinitionInterface
     */
    public function createJob();

    /**
     * @return Definition\FunctionDefinitionInterface
     */
    public function createFunction();
}
