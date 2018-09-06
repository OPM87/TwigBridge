<?php

/**
 * This file is part of the TwigBridge package.
 *
 * @copyright Robert Crowe <hello@vivalacrowe.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TwigBridge\Twig;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\ViewFinderInterface;
use InvalidArgumentException;
use Twig\Source;
use Twig\Error\LoaderError;
use Twig\Loader\LoaderInterface;
use TwigBridge\Twig\Normalizers\Normalizer;

/**
 * Basic loader using absolute paths.
 */
class Loader implements LoaderInterface
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Illuminate\View\ViewFinderInterface
     */
    protected $finder;

    /**
     * @var \TwigBridge\Twig\Normalizers\Normalizer
     */
    protected $normalizer;

    /**
     * @var array Template lookup cache.
     */
    protected $cache = [];

    /**
     * @param \Illuminate\Filesystem\Filesystem       $files The filesystem
     * @param \Illuminate\View\ViewFinderInterface    $finder
     * @param \TwigBridge\Twig\Normalizers\Normalizer $normalizer
     */
    public function __construct(Filesystem $files, ViewFinderInterface $finder, Normalizer $normalizer)
    {
        $this->files = $files;
        $this->finder = $finder;
        $this->normalizer = $normalizer;
    }

    /**
     * Return path to template without the need for the extension.
     *
     * @param string $name Template file name or path.
     *
     * @throws LoaderError
     * @return string Path to template
     */
    public function findTemplate($name)
    {
        if ($this->files->exists($name)) {
            return $name;
        }

        $name = $this->normalizer->normalize($name);

        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        try {
            $this->cache[$name] = $this->finder->find($name);
        } catch (InvalidArgumentException $ex) {
            throw new LoaderError($ex->getMessage());
        }

        return $this->cache[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        try {
            $this->findTemplate($name);
        } catch (LoaderError $exception) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getSourceContext($name)
    {
        $path = $this->findTemplate($name);

        return new Source($this->files->get($path), $name, $path);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKey($name)
    {
        return $this->findTemplate($name);
    }

    /**
     * {@inheritdoc}
     */
    public function isFresh($name, $time)
    {
        return $this->files->lastModified($this->findTemplate($name)) <= $time;
    }
}
