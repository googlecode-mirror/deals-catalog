<?php
defined('_JEXEC') or die('Restricted access');

$db = &JFactory::getDBO();

$query = "select * from #__deal_productcategories";
$db->setQuery($query);
$result = $db->loadAssocList();
?>
<link rel="stylesheet" type="text/css" href="modules/mod_dealcategory/deal_category.css"/>
<div id="allcat_cont">
	<span id="allcat">
		<div id="css_dropdown_verticale">
			<ul>
				<?php
				foreach($result as $row)
				{
					?>
					<li> <a href="index.php?option=com_dealcatalog&task=categorysearch&category=<?php echo $row['id']; ?>&Itemid=<?php echo $_REQUEST['Itemid']; ?>"> 
						<?php echo $row['category_name']; ?> </a>
					</li>
					<?php
				}
				?>
			</ul>				
		</div>
	</span>
</div>