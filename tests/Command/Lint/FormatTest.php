<?php

namespace TwigBridge\Tests\Command\Lint;

use Mockery as m;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;
use TwigBridge\Command\Lint;

class FormatTest extends Base
{
    public function testInstance()
    {
        $command = new Lint;

        $this->assertInstanceOf('Illuminate\Console\Command', $command);
    }

    public function testEmpty()
    {
        $command = new Lint;
        $app     = $this->getApplication();

        $command->setLaravel($app);

        $finder = m::mock('Symfony\Component\Finder\Finder');
        $finder->shouldReceive('files')->andReturn($finder);
        $finder->shouldReceive('in')->andReturn($finder);
        $finder->shouldReceive('name')->andReturn([]);
        $command->setFinder($finder);
        $this->assertEquals(3, $finder->mockery_getExpectationCount());

        $input  = new ArrayInput([]);
        $output = m::mock('Symfony\Component\Console\Output\NullOutput')->makePartial();
        $output->shouldReceive('writeln')->with('<comment>0/0 valid files</comment>');
        $this->assertEquals(1, $output->mockery_getExpectationCount());

        $command->run($input, $output);
    }

    public function testEmptyJSON()
    {
        $command = new Lint;
        $app     = $this->getApplication();

        $command->setLaravel($app);

        $finder = m::mock('Symfony\Component\Finder\Finder');
        $finder->shouldReceive('files')->andReturn($finder);
        $finder->shouldReceive('in')->andReturn($finder);
        $finder->shouldReceive('name')->andReturn([]);
        $this->assertEquals(3, $finder->mockery_getExpectationCount());
        $command->setFinder($finder);

        $input  = new ArrayInput([
            '--format' => 'json'
        ]);
        $output = m::mock('Symfony\Component\Console\Output\NullOutput')->makePartial();
        $output->shouldReceive('writeln')->with("[]");
        $this->assertEquals(1, $output->mockery_getExpectationCount());

        $command->run($input, $output);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidFormat()
    {
        $command = new Lint;
        $app     = $this->getApplication();

        $command->setLaravel($app);

        $finder = m::mock('Symfony\Component\Finder\Finder');
        $finder->shouldReceive('files')->andReturn($finder);
        $finder->shouldReceive('in')->andReturn($finder);
        $finder->shouldReceive('name')->andReturn([]);
        $this->assertEquals(3, $finder->mockery_getExpectationCount());
        $command->setFinder($finder);

        $input  = new ArrayInput([
            '--format' => 'foo'
        ]);
        $output = m::mock('Symfony\Component\Console\Output\NullOutput')->makePartial();

        $command->run($input, $output);
    }
}
