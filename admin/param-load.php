<?php
$subCategoryId = $_POST['subCategoryId'];
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}

require '../vendor/autoload.php';

$productsObj = new admin\products\ProductsView();
$paramArray = $productsObj->showParams($subCategoryId);
$paramsValuesArray = $productsObj->showParamsValues();

foreach ($paramArray as $param) {
	?>
	<div class="form-row mb-4" style="margin-top: 2%;">
        	<div class="md-form md-outline" style="margin: 0;padding: 0;">
			  	<input id="param" class="form-control unsaved" type='hidden' name='param[]' value="<?php echo $param['param_id']; ?>">
			</div>
			<div class="md-form md-outline" style="margin: 0;padding: 0;">
			  	<input id="paramValue" class="form-control unsaved" type='text' name='paramValue[]' required>
			  	<label for="paramValue"><?php echo $param['param_name']; ?></label>
			</div>
    </div>
	<?php
}
?>