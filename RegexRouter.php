<?php
class RegexRouter
{
    private $routes = array();

    public function route($pattern, $callback)
	{
		if (isset($this->routes[$pattern])) {
			trigger_error("This route already exists: " . $pattern, E_USER_NOTICE);
			return;
		}

        $this->routes[$pattern] = $callback;
	}

    public function execute($uri)
	{
        foreach ($this->routes as $pattern => $callback) {
			if (!is_callable($callback)) {
				trigger_error("Unknown route.", E_USER_NOTICE);
				return;
			}

            if (preg_match($pattern, $uri, $params) === 1) {
                array_shift($params);
                return call_user_func_array($callback, array_values($params));
            }
        }
    }
}
