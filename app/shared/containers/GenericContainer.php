<?php

namespace app\shared\containers;

use DI\ContainerBuilder;

const PRE_PATH = '\\..\\..\\infraestructure\\containers\\';
const SUB_PATH = '\\infraestructure\\containers\\';

class GenericContainer{

    public static function getDependency(string $dir, string $fileName, $dependencyReference, $extraPrefix = ''){
        $containerBuilder = new ContainerBuilder();
        $midRoute = $extraPrefix ? ($extraPrefix.SUB_PATH) : PRE_PATH;
        $containerBuilder->addDefinitions(require $dir. $midRoute. $fileName);
        $container = $containerBuilder->build();
        $dependency = $container->get($dependencyReference);
        return $dependency;
    }
}

