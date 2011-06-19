<?php
/*
	An HTML component has methods to generate the HTML code corresponding to
	this component.
*/

interface IHtmlComponent {
	public function getId();
	public function getClass();
	public function generateHtml();
	public function getHtml();
}
?>