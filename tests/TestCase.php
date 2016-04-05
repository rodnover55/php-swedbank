<?php
namespace Rnr\Tests\Swedbank;

use Dotenv\Dotenv;
use PHPUnit_Framework_TestCase as BaseTestCase;
/**
 * @author Sergei Melnikov <me@rnr.name>
 */
abstract class TestCase extends BaseTestCase
{
    protected function setUp()
    {
        parent::setUp();
        
        $dotenv = new Dotenv(dirname(__DIR__));
        $dotenv->load();

    }
}