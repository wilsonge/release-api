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
		$filter = [];

		/** @var \FOF30\Model\DataModel $model */
		$model = FOF30\Container\Container::getInstance('com_ars')->factory->model('model');
		$item = $model->find($filter);

		// Load the item into the document's buffer
		$this->getApplication()->getDocument()->setBuffer($item);

		return true;
	}
}
