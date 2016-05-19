<?php namespace App\Http\Annotations;

use Collective\Annotations\Routing\Annotations\Annotations\Annotation;
use Collective\Annotations\Routing\Annotations\MethodEndpoint;
use ReflectionMethod;

/**
 * Vote Annotation
 * @Annotation
 */
class Vote extends Annotation {

    /**
     * {@inheritdoc}
     */
    public function modify(MethodEndpoint $endpoint, ReflectionMethod $method)
    {
        if ($endpoint->hasPaths())
        {
            foreach ($endpoint->getPaths() as $path)
            {
                $path->middleware = array_merge($path->middleware, (array) 'vote');
            }
        }
        else
        {
            $endpoint->middleware = array_merge($endpoint->middleware, (array) 'vote');
        }
    }

}