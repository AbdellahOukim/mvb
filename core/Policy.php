<?php

namespace Core;

use Core\Auth;

class Policy
{
    public static function check(string $policyClass, string $method, $resource): bool
    {
        if (!class_exists($policyClass)) {
            throw new \Exception("Policy $policyClass not found");
        }

        $user = Auth::user();
        $policy = new $policyClass();

        if (!method_exists($policy, $method)) {
            throw new \Exception("Method $method not found in policy $policyClass");
        }

        return $policy->$method($user, $resource);
    }
}
