<?php
namespace LunchTime\DeliveryBundle\Request\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Symfony\Component\HttpFoundation\Request;

class ArrayParamConverter implements ParamConverterInterface
{

    public function supports(ConfigurationInterface $configuration)
    {
        return "array" === $configuration->getClass();
    }

    public function apply(Request $request, ConfigurationInterface $configuration)
    {
        $param = $configuration->getName();

        if (!$request->attributes->has($param)) {
            return false;
        }

        $value = $request->attributes->get($param);
        $array = array_map('trim', explode(",", $value));

        $request->attributes->set($param, $array);

        return true;
    }
}