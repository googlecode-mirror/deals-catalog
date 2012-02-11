<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

class TOOLBAR_deal {

	function _merchant() { 
	
		JToolBarHelper::title( JText::_( 'Merchant Users list' ), 'cpanel.png' );
		JToolBarHelper::trash('merchantremove');
		JToolBarHelper::editListX('merchantedit');
		JToolBarHelper::addNewX('merchantinsert');
	}

	function _merchantinsert() {
	
		JToolBarHelper::title( JText::_( 'Merchant New user' ), 'cpanel.png' );
		JToolBarHelper::save('merchantsave');
		JToolBarHelper::apply('merchantsave');
		JToolBarHelper::cancel('merchant');		
	}
	
	function _merchantedit() {
	
		JToolBarHelper::title( JText::_( 'Merchant user Amend' ), 'cpanel.png' );
		JToolBarHelper::save('merchanteditsave');
		JToolBarHelper::apply('merchanteditsave');
		JToolBarHelper::cancel('merchant');		
	}
	
	function _customers() { 
	
		JToolBarHelper::title( JText::_( 'Customers Users list' ), 'cpanel.png' );
		JToolBarHelper::trash('customersremove');
		JToolBarHelper::editListX('customersedit');
		JToolBarHelper::addNewX('customersinsert');
	}
	
	function _customersinsert() {
	
		JToolBarHelper::title( JText::_( 'Customer New user' ), 'cpanel.png' );
		JToolBarHelper::save('customerssave');
		JToolBarHelper::apply('customerssave');
		JToolBarHelper::cancel('customers');		
	}
	
	function _customersedit() {
	
		JToolBarHelper::title( JText::_( 'Customers user Amend' ), 'cpanel.png' );
		JToolBarHelper::save('customerseditsave');
		JToolBarHelper::apply('customerseditsave');
		JToolBarHelper::cancel('customers');	
	}
	
	function _categories() {
	
		JToolBarHelper::title( JText::_( 'Product Categories' ), 'cpanel.png' );
		JToolBarHelper::trash('categoriesremove');
		JToolBarHelper::editListX('categoriesedit');
		JToolBarHelper::addNewX('categoriesinsert');
	}
	
	function _categoriesinsert() {
	
		JToolBarHelper::title( JText::_( 'Add new product category' ), 'cpanel.png' );
		JToolBarHelper::save('categoriessave');
		JToolBarHelper::apply('categoriessave');
		JToolBarHelper::cancel('categories');
	}
	
	function _manufacturers() {
	
		JToolBarHelper::title( JText::_( 'Product manufacturers' ), 'cpanel.png' );
		JToolBarHelper::trash('manufacturersremove');
		JToolBarHelper::editListX('manufacturersedit');
		JToolBarHelper::addNewX('manufacturersinsert');
	}
	
	function _manufacturersinsert() {
	
		JToolBarHelper::title( JText::_( 'Add new product Manufacturer' ), 'cpanel.png' );
		JToolBarHelper::save('manufacturerssave');
		JToolBarHelper::apply('manufacturerssave');
		JToolBarHelper::cancel('manufacturers');
	}
	
	function _products() {
	
		JToolBarHelper::title( JText::_( 'Products lists' ), 'cpanel.png' );
		JToolBarHelper::trash('productsremove');
		JToolBarHelper::editListX('productsedit');
		JToolBarHelper::addNewX('productsinsert');
	}
	
	function _productsinsert() {
	
		JToolBarHelper::title( JText::_( 'Add new products ' ), 'cpanel.png' );
		JToolBarHelper::save('productssave');
		JToolBarHelper::apply('productssave');
		JToolBarHelper::cancel('products');
	}
	
	function _productsedit() {
	
		JToolBarHelper::title( JText::_( 'Edit products ' ), 'cpanel.png' );
		JToolBarHelper::save('productseditsave');
		JToolBarHelper::apply('productseditsave');
		JToolBarHelper::cancel('products');
	}
	
	function _productlistingsanddeals() {
	
		JToolBarHelper::title( JText::_( 'Products listing and deals' ), 'cpanel.png' );
		JToolBarHelper::trash('productlistingsanddealsremove');
		JToolBarHelper::editListX('productlistingsanddealsedit');
		JToolBarHelper::addNewX('productlistingsanddealsinsert');
	}
	
	function _productlistingsanddealsinsert() {
	
		JToolBarHelper::title( JText::_( 'Add new products Listing and Deals ' ), 'cpanel.png' );
		JToolBarHelper::save('productlistingsanddealssave');
		JToolBarHelper::apply('productlistingsanddealssave');
		JToolBarHelper::cancel('productlistingsanddeals');
	}
	
	function _coupons()
	{
		
		JToolBarHelper::title( JText::_( 'Products Deals Coupons for users lists' ), 'cpanel.png' );
		JToolBarHelper::trash('couponsremove');
		JToolBarHelper::editListX('couponsedit');
		JToolBarHelper::addNewX('couponsinsert');
	}
	
	function _couponsinsert()
	{
	
		JToolBarHelper::title( JText::_( 'Add / Edit product deals Coupons ' ), 'cpanel.png' );
		JToolBarHelper::save('couponssave');
		JToolBarHelper::apply('couponssave');
		JToolBarHelper::cancel('Coupons');
	}
	
	function _DEFAULT() {

		JToolBarHelper::title( JText::_( 'Deal Catalog' ), 'cpanel.png' );		
	}
}
?>