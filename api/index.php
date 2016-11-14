<?php
/**
 * Joomla! API Application
 *
 * @copyright  Copyright (C) 2016 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

/**
 * Define the application's minimum supported PHP version as a constant so it can be referenced within the application.
 */
define('JOOMLA_MINIMUM_PHP', '5.3.10');

if (version_compare(PHP_VERSION, JOOMLA_MINIMUM_PHP, '<'))
{
	die('Your host needs to use PHP ' . JOOMLA_MINIMUM_PHP . ' or higher to run this version of Joomla!');
}

// Saves the start time and memory usage.
$startTime = microtime(1);
$startMem  = memory_get_usage();

/**
 * Constant that is checked in included files to prevent direct access.
 * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
 */
define('_JEXEC', 1);

if (file_exists(__DIR__ . '/defines.php'))
{
	include_once __DIR__ . '/defines.php';
}

if (!defined('_JDEFINES'))
{
	define('JPATH_BASE', __DIR__);
	require_once JPATH_BASE . '/includes/defines.php';
}

require_once JPATH_BASE . '/includes/framework.php';

// Set profiler start time and memory usage and mark afterLoad in the profiler.
JDEBUG ? $_PROFILER->setStart($startTime, $startMem)->mark('afterLoad') : null;

// Every other library can be loaded after load time. But JApplication requires the class to start with J, so won't
// meet our autoloader's convention. So let's just load it right here right now and then autoload the rest of the API's
JLoader::register('JApplicationApi', JPATH_LIBRARIES . '/api/application/api.php');

// Register the library base path for the application libraries.
JLoader::registerPrefix('Api', dirname(__DIR__) . '/libraries/api');

// Set system error handling
JError::setErrorHandling(E_NOTICE, 'callback', array('ApiError', 'handleLegacyError'));
JError::setErrorHandling(E_WARNING, 'callback', array('ApiError', 'handleLegacyError'));
JError::setErrorHandling(E_ERROR, 'callback', array('ApiError', 'handleLegacyError'));

// Set a custom Exception handler
restore_exception_handler();
set_exception_handler(array('ApiError', 'handleUncaughtThrowable'));

// Register the application client
JApplicationHelper::addClientInfo((object) array('id' => 3, 'name' => 'api', 'path' => JPATH_BASE));

// Instantiate and execute the application.
JFactory::getApplication('api')->execute();
