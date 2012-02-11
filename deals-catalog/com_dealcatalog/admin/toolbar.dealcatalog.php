<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( JApplicationHelper::getPath( 'toolbar_html' ) );

switch ( $task )
{	
	default:
		TOOLBAR_deal::_DEFAULT();
		break;
		
	case 'merchant':
		TOOLBAR_deal::_merchant();
		break;
		
	case 'merchantinsert'  :
		TOOLBAR_deal::_merchantinsert();
		break;
		
	case 'merchantedit' :
		TOOLBAR_deal::_merchantedit();
		break;
		
	case 'customers'	:
		TOOLBAR_deal::_customers();
		break;
		
	case 'customersinsert' :
		TOOLBAR_deal::_customersinsert();
		break;
		
	case 'customersedit' :
		TOOLBAR_deal::_customersedit();
		break;
		
	case 'categories':
		TOOLBAR_deal::_categories();
		break;
		
	case 'categoriesinsert':
		TOOLBAR_deal::_categoriesinsert();
		break;
		
	case 'categoriesedit':
		TOOLBAR_deal::_categoriesinsert();
		break;
		
	case 'manufacturers':
		TOOLBAR_deal::_manufacturers();
		break;
		
	case 'manufacturersinsert':
		TOOLBAR_deal::_manufacturersinsert();
		break;
		
	case 'manufacturersedit':
		TOOLBAR_deal::_manufacturersinsert();
		break;
		
	case 'products':
		TOOLBAR_deal::_products();
		break;
		
	case 'productsinsert':
		TOOLBAR_deal::_productsinsert();
		break;
		
	case 'productsedit':
		TOOLBAR_deal::_productsedit();
		break;
		
	case 'productlistingsanddeals':
		TOOLBAR_deal::_productlistingsanddeals();
		break;
		
	case 'productlistingsanddealsinsert':
		TOOLBAR_deal::_productlistingsanddealsinsert();
		break;
		
	case 'productlistingsanddealsedit':
		TOOLBAR_deal::_productlistingsanddealsinsert();
		break;
		
	case 'Coupons':
		TOOLBAR_deal::_coupons();
		break;
		
	case 'couponsinsert':
		TOOLBAR_deal::_couponsinsert();
		break;
		
	case 'couponsedit':
		TOOLBAR_deal::_couponsinsert();
		break;	
		
}
?>