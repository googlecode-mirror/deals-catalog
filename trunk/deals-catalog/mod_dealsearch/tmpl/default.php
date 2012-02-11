<?php
defined('_JEXEC') or die('Restricted access');

$db = &JFactory::getDBO();

$query = "select * from #__deal_productcategories";
$db->setQuery($query);
$result = $db->loadAssocList();
?><script type="text/javascript">function checks(){	if(document.categoryproduct.category.value==0)	{		alert('Select the category for the product');		return false;	}	if(document.categoryproduct.product_name.value=='Product name')	{		alert('Enter the product name');		document.categoryproduct.product_name.focus();		return false;	}	return true;}</script>
<link rel="stylesheet" type="text/css" href="modules/mod_dealsearch/dealsearch.css"/>
<div id="categorysearch">
	<form name="categoryproduct" method="post" action="index.php?option=com_dealcatalog&task=categoryproduct&Itemid=<?php echo $_REQUEST['Itemid']; ?>" onsubmit="return checks();">
		<div class="categorylabel1"> Search : </div>
		<div class="categorylabel2">
			<select name="category">
				<option value="0"> Select Category </option>
				<?php
					foreach($result as $row)
					{
						?>
						<option value="<?php echo $row['id']; ?>"> <?php echo $row['category_name']; ?> </option>
						<?php
					}
				?>
			</select>
		</div>
		<div class="categorylabel3">
			<input type="text" name="product_name" value="Product name" onclick="categoryproduct.product_name.value='';">
		</div>
		<div class="categorylabel4">
			<input type="submit" name="searchcategory" class="searchcategory" value="" />
		</div>
	</form>
</div>