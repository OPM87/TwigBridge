<?php

/**
 * This file is part of the TwigBridge package.
 *
 * @copyright Robert Crowe <hello@vivalacrowe.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TwigBridge;

use Illuminate\Foundation\Application;
use InvalidArgumentException;
use Twig_Error;

/**
 * TwigBridge deals with creating an instance of Twig.
 */
class Bridge
{
    /**
     * @var string TwigBridge version
     */
    const VERSION = '0.6.0';

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Create a new instance.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle dynamic, static calls.
     *
     * All dynamic calls are passed to \Twig_Environment.
     *
     * @param  string  $method
     * @param  array   $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        $instance = $this->app['twig'];

        switch (count($args)) {
            case 0:
                return $instance->$method();

            case 1:
                return $instance->$method($args[0]);

            case 2:
                return $instance->$method($args[0], $args[1]);

            case 3:
                return $instance->$method($args[0], $args[1], $args[2]);

            case 4:
                return $instance->$method($args[0], $args[1], $args[2], $args[3]);

            default:
                return call_user_func_array(array($instance, $method), $args);
        }
    }

    /**
     * Lint (check) the syntax of a file on the view paths.
     *
     * @param string $file File to check. Supports dot-syntax.
     *
     * @return bool Whether the file passed or not.
     */
    public function lint($file)
    {
        $twig     = $this->app['twig'];
        $template = $this->app['twig.loader.viewfinder']->getSource($file);

        if (!$template) {
            throw new InvalidArgumentException('Unable to find file: '.$file);
        }

        try {
            $twig->parse($twig->tokenize($template, $file));
        } catch (Twig_Error $e) {
            return false;
        }

        return true;
    }
}
