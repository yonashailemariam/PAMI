<?php
/**
 * AMI basic use example.
 *
 * PHP Version 5
 *
 * @category Ami
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://www.noneyet.ar/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://www.noneyet.ar/
 */

// Setup include path.
ini_set(
    'include_path',
    implode(
        PATH_SEPARATOR,
        array(
            ini_get('include_path'),
            implode(DIRECTORY_SEPARATOR, array('..', '..', '..', 'src', 'mg'))
        )
    )
);

////////////////////////////////////////////////////////////////////////////////
// Mandatory stuff to bootstrap.
////////////////////////////////////////////////////////////////////////////////
require_once 'AMI/Autoloader/Autoloader.php'; // Include ding autoloader.
Autoloader::register(); // Call autoloader register for ding autoloader.
use AMI\Client\Impl\ClientImpl;
use AMI\Listener\IEventListener;
use AMI\Message\Event\EventMessage;

class A implements IEventListener
{
    public function handle(EventMessage $event)
    {
        var_dump($event);
    }
}
////////////////////////////////////////////////////////////////////////////////
// Code STARTS.
////////////////////////////////////////////////////////////////////////////////
error_reporting(E_ALL);
ini_set('display_errors', 1);

try
{
	$a = new ClientImpl($argv[1], $argv[2], $argv[3], $argv[4], 60, 60);
	$a->registerEventListener(new A());
	$a->open();
	while(true)
	{
	    $a->process();
	    usleep(1000); // 1ms delay
	}
	$a->close();
} catch (Exception $e) {
	echo $e->getMessage() . "\n";
}
////////////////////////////////////////////////////////////////////////////////
// Code ENDS.
////////////////////////////////////////////////////////////////////////////////
