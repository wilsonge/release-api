<?php
/**
 * Joomla! API Application
 *
 * @copyright  Copyright (C) 2016 Michael Babker. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

defined('_JEXEC') or die;

/**
 * Controller processing requests for items
 *
 * @since  1.0
 */
class ApiControllerBreakdownMajor extends JControllerBase
{
	/**
	 * Execute the controller.
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	public function execute()
	{
		// This will autoload the ARS files
		FOF30\Container\Container::getInstance('com_ars');

		// Now get the totals
		$total   = Akeeba\ReleaseSystem\Site\Helper\DownloadCounter::getCountForVgroup(1);
		$total10 = Akeeba\ReleaseSystem\Site\Helper\DownloadCounter::getCountForCategory(1);
		$total15 = Akeeba\ReleaseSystem\Site\Helper\DownloadCounter::getCountForCategory(2);
		$total25 = Akeeba\ReleaseSystem\Site\Helper\DownloadCounter::getCountForCategory(3);
		$total30 = Akeeba\ReleaseSystem\Site\Helper\DownloadCounter::getCountForCategory(4);

		$item = [
			'total' => $total,
			'branches' => ['1.0' => $total10, '1.5' => $total15, '2.5' => $total25, '3.0' => $total30]
		];

		// Load the item into the document's buffer
		$this->getApplication()->getDocument()->setBuffer($item);

		return true;
	}
}
