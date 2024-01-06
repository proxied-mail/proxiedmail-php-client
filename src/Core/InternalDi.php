<?php

declare(strict_types=1);

namespace ProxiedMail\Client\Core;

use ReflectionParameter;
use ReflectionClass;

class InternalDi
{
    private array $binds = [];

    public function bind(string $class, $object): self
    {
        $this->binds[$class] = $object;
        return $this;
    }

    public function b(object $object): self
    {
        return $this->bind(get_class($object), $object);
    }

    public function create(string $class, ?string $parent = null)
    {
        if (isset($this->binds[$class])) {
            return $this->binds[$class];
        }

        if (!class_exists($class)) {
            throw new \RuntimeException(
                !empty($parent) ? "Class {$class} not found for {$parent}" : "Class {$class} not found"
            );
        }

        $reflection = new ReflectionClass($class);
        if (empty($reflection->getConstructor())) {
            return new $class;
        }

        $params = $reflection->getConstructor()->getParameters();
        $actionArgumentsObjects = array_reduce(
            $params,
            function (array $acc, ReflectionParameter $parameter) use ($class) {
                try {
                    $acc[] = $parameter->getDefaultValue();
                    return $acc;
                } catch (\ReflectionException $e) {
                }

                $acc[] = $this->create($parameter->getType()->getName(), $class);
                return $acc;
            },
            []
        );

        return new $class(...$actionArgumentsObjects);
    }
}
