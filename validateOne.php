<?php 
include 'header.php'; 

if (isset($_POST['validate'])) {
    include 'classes/validators/vatValidatorItalian.php';
    
    $validator = new italianVatValidator();
    $result = $validator->validate($_POST['vat']);    
    $status = $result['valid'] ? 'valid' : 'invalid';
    $statusDescription =  $result['description'];
    $isCorrected = $result['isCorrected'] ? '(Corrected)' : '';
    
};


?>


<h2>Validate Single VAT Number</h2>

<form method="post">
    <input type="text" name="vat" placeholder="Enter VAT number" required>
    <button type="submit" name="validate">Validate</button>
</form>
<?php if (!empty($status)) {  ?>

 <div>
            <?=$statusDescription?>
 </div>

<?php } ?>

<?php include 'footer.php'; ?>
