<?php
/**
 * Part of Vaseman project. 
 *
 * @copyright  Copyright (C) 2014 {ORGANIZATION}. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

namespace Vaseman\Plugin;

use Windwalker\Event\Event;
use Windwalker\Structure\Structure;

/**
 * The MenuPlugin class.
 * 
 * @since  {DEPLOY_VERSION}
 */
class MenuPlugin extends AbstractPlugin implements DataProviderInterface
{
	/**
	 * loadProvider
	 *
	 * @param Event $event
	 *
	 * @return  void
	 */
	public function loadProvider(Event $event)
	{
		$data = $event['data'];

		// Get version
		if ($data->path[0] == 'documentation')
		{
			$data->version = $data->path[1];
		}
		
		$menus = new Structure;
		$menus->loadFile(__DIR__ . '/menus.yml', 'yaml');

		$event['data']->menus = $menus->toArray();
	}
}
