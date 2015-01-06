<?php

namespace Detail\FileConversion\Job\Definition;

use ArrayObject;
use RecursiveIteratorIterator;
use RecursiveArrayIterator;

use Zend\Stdlib\ArrayUtils;

abstract class BaseDefinition
{
    protected $options = array();

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return BaseDefinition
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function applyOptions(array $options)
    {
        $this->options = ArrayUtils::merge($this->options, $options);
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return BaseDefinition
     */
    public function setOption($name, $value)
    {
        // Merge if both existing and new option value are arrays...
        if (is_array($value) && isset($this->options[$name]) && is_array($this->options[$name])) {
            $value = ArrayUtils::merge($this->options[$name], $value);
        }

        $this->options[$name] = $value;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function getOption($name, $default = null)
    {
        return array_key_exists($name, $this->options) ? $this->options[$name] : $default;
    }

    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $data = new ArrayObject($this->options);

        $dataIterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator($data),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($dataIterator as $key => $value) {
            if ($value instanceof self) {
                $value = $value->toArray();
            }

            if (is_array($value)) {
                $value = new ArrayObject($value);
            }

            // Apply changes value
            if ($value != $dataIterator->current()) {
                /** @var RecursiveArrayIterator $innerIterator */
                $innerIterator = $dataIterator->getInnerIterator();
                $innerIterator->offsetSet($key, $value);
            }
        }

        // Helper function which recursively converts to a normal (recursive) array again
        $toArray = function($data) use (&$toArray) { // Reference is required for "recursive closure"...
            if ($data instanceof ArrayObject) {
                $data = (array) $data;
            }

            return is_array($data) ? array_map($toArray, $data) : $data;
        };

        return $toArray($data);
    }
}
