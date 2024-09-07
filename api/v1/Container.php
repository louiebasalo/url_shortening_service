<?php

namespace Api\V1;
use Closure;
use ReflectionClass;

class Container {

    private array $registry = [];

    public function set(string $name, Closure $value) : void  //Closure clas is a class that is used to represent an anonymous function
    {
        $this->registry[$name] = $value;
    }

    public function get(string $className) : object 
    {
        if (array_key_exists($className, $this->registry)) {
            return $this->registry[$className]();
        } 

        $reflector = new ReflectionClass($className);
        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return new $className;
        }

        $dependencies = [];
        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();    //this gets the parameter in the constructir of the class $classname
            $dependencies[] = $this->get((string) $type); //then we use this same function (get()) to get the object of that class (the type of the parameter in the constructor of $classname) and save it to the array $dependencies. this will continue as long as the found type as class has its own dependency too. this is known as an object graph. we can var_dump the $dependency array to see the structure of the created objects starting from the first passed $className
        }

        return new $className(...$dependencies);
    }

}