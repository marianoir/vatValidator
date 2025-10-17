<?php 
include 'header.php'; 


if (isset($_POST["csvsubmit"]))
{

	if (isset($_FILES['csv'])) {

		include_once 'classes/csv/csvVatUploader.php';
		include_once 'classes/validators/vatProcessor.php';
		include_once 'classes/validators/vatValidatorItalian.php';
		include_once 'database/vatRepository.php';
		
		$file = $_FILES['csv']['tmp_name'];

		// We upload the csv and return the array with the data
		$vatNumbersUploaded = csvVatUploader::uploadCsv($file);

		// Processing the data with italianvalidator (in case we have another country, we build the spain validator or any)		
		$csvProcessor = new vatProcessor(new italianVatValidator());

		// We take the results of the validation
		$csvItalianVatsResult = $csvProcessor->validateVats($vatNumbersUploaded);

		// now we extract only the valid vat so we can insert them in the database
		$validVats = array_filter($csvItalianVatsResult, function($vat) {
			return $vat['valid'] === true;
		});

		// we extract the invalid vats so we can show them in another table in red.
		$invalidVats = array_filter($csvItalianVatsResult, function($vat) {
			return $vat['valid'] === false;
		});	

		// we call the repository and we send the data to be saved.
		$vatRepository = new vatRepository("localhost","vat_validator","root","");
		$vatRepository->insertVats($validVats);

	}		

}
?>

<h2>Upload Italian VAT CSV</h2>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="csv" accept=".csv">
    <button type="submit" name="csvsubmit">Upload</button>
</form>

<p>Or <a href="validateOne.php">Validate one online</a></p>


<?php
if (isset($_POST["csvsubmit"]))
{
	?>
	<h3>Valid VATs</h3>
	<?php
	if (!empty($validVats))
	{
		?>
		<table>
			<thead>
				<tr>
					<th>Original VAT</th>
					<th>Corrected VAT</th>
					<th>Status</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($validVats as $vat): ?>
				<tr>
					<td><?=$vat['original']?></td>
					<td><?=$vat['corrected']?></td>
					<td><?=$vat['status']?></td>
					<td><?=$vat['description']?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php
	} else {
		echo "<p>No valid VATs uploaded</p>";
	}
	?>

	<h3>Invalid VATs</h3>
	<?php
	if (!empty($invalidVats))
	{
		?>
		<table>
			<thead>
				<tr>
					<th>Original VAT</th>					
					<th>Status</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($invalidVats as $vat): ?>
				<tr>
					<td><?=$vat['original']?></td>					
					<td><?=$vat['status']?></td>
					<td><?=$vat['description']?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php
	} else {
		echo "<p>No invalid VATs uploaded</p>";
	}
}
?>


<?php include 'footer.php'; ?>


