<?php
/*
	A menu is a component giving a list of entries in a specific block.
*/

class MenuComponent extends SimpleBlockComponent {
	function __construct(Menu $menu) {
		$this->setClass('menu');
		
		if ($menu->getTitle() !== null) {
			$this->addComponent(new Title($menu->getTitle()));
		}
		
		$list = new SimpleListComponent();
		foreach($menu->getEntries() as $entry) {
			$list->addComponent($entry);
		}
		$this->addComponent($list);
	}
}
?>
