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
		$container = FOF30\Container\Container::getInstance('com_ars');

		$mapping = [
			10 => 1,
			15 => 2,
			25 => 3,
			30 => 4
		];

		$majorVersion = $this->getInput()->getInt('version');
		$categoryId = $mapping[$majorVersion];

		$categoryTotal = Akeeba\ReleaseSystem\Site\Helper\DownloadCounter::getCountForCategory($categoryId);

		$releasesModel = $container->factory->model('Releases');
		$counts = [];

		foreach ($releasesModel->category($categoryId)->get(true) as $release)
		{
			$totalCount = 0;

			foreach ($release->items as $item)
			{
				$totalCount += $item->hits;
			}

			$counts[$release->version] = $totalCount;
		}

		$item = [
			'total' => $categoryTotal,
			'branches' => [$counts]
		];

		// Load the item into the document's buffer
		$this->getApplication()->getDocument()->setBuffer($item);

		return true;
	}
}
