<!DOCTYPE html>
<html>

<head>
	<title>Barcode Generator</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
		/* .article {
			min-height: 90px;
			max-height: 100px;
			width: 20px;
			float: left;
			writing-mode: tb-rl;
		} */

		.article {
		    margin:0;
			min-height: 95px;
			float: left;
			writing-mode: tb-rl;
			margin-left: 10px;
			line-height: 1;
		}

		.content {
			width: 120px;
			float: left;
			padding: 2px;
		}

		.name {
			height: auto;
			width: 120px;
			font-size: 11px;
		}

		.img {
			height: 60px;
			width: 120px;
		}

		.pid {
			height: 15px;
			width: 120px;
		}

		.price {
			height: 10px;
			width: 120px;
		}

		.date {
			height: 90px;
			width: 20px;
			float: right;
			writing-mode: tb-rl;
		}

		.mytext {
			height: 25px !important;
			padding: 2px;
		}
	</style>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('barcode/style.css'); ?>" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="shortcut icon" href="<?php echo base_url('barcode/favicon.ico'); ?>" />
	<script src="<?php //echo base_url('barcode/jquery-1.7.2.min.js'); 
					?>"></script>
	<script src="<?php //echo base_url('barcode/barcode.js'); 
					?>"></script>
	<script type="text/javascript">
		function printpage() {
			// document.getElementById('printButton').style.visibility="hidden";
			document.querySelector('.documentbody').style.display = "none";
			document.getElementById("printButton").style.cssText = "visibility:hidden;height:0px;margin-top:0px"
			document.getElementById('printButton2').style.visibility = "hidden";
			window.print();
			document.getElementById('printButton').style.visibility = "visible";
			location.reload();
		}
	</script>

</head>

<body class="">
	<div class="container-fluid">
		<div class="row documentbody">
			<div class="col-md-12">
				<form class="form-horizontal" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
					<section class="" id="printButton" style="background:#f4f4f4;height:200px;">
						<div class="form-group" style="margin: 0;">
							<div class="col-xs-12 text-center">
								<h3 class="text-info">Barcode Generator</h3>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-2" for="text">Product ID</label>
							<div class="col-xs-2">
								<input type="text" name="pID" class="form-control mytext" placeholder="Product ID ..." value="<?php echo $product->Product_Code; ?>" />
							</div>

							<label class="control-label col-xs-2" for="text">Product Name</label>
							<div class="col-xs-2">
								<input type="text" name="pname" class="form-control mytext" placeholder="Product name ..." value="<?php echo $product->Product_Name; ?>" />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-2" for="Price">Price </label>
							<div class="col-xs-2">
								<input type="text" name="Price" class="form-control mytext" placeholder="Product price ..." value="<?php echo $product->Product_SellingPrice; ?>" />
							</div>

							<label class="control-label col-xs-2" for="Price">Article </label>
							<div class="col-xs-2">
								<input type="text" name="article" class="form-control mytext" placeholder="Article ..." />
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-2" for="qty">Quantity</label>
							<div class="col-xs-2">
								<input type="text" name="qty" class="form-control mytext" placeholder="Product quantity ...">
							</div>

							<label style="display: none;" class="control-label col-xs-2" for="date">Date</label>
							<div class="col-xs-2" style="display: none;">
								<input type="date" name="date" class="form-control mytext" />
							</div>
							<div class="col-xs-4" style="display: flex;justify-content: end;gap: 5px;">
								<input type="submit" name="submit" value="Generate" class="btn btn-primary" />
								<input name="print" type="button" value="Print" id="printButton2" onClick="printpage()" class="btn btn-success" style="width:100px;" />
							</div>
						</div>
					</section>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="output col-md-8 col-md-offset-2">
				<section class="output">
					<?php

					if (isset($_REQUEST['submit'])) {
						$PID = $_POST['pID'];
						$Price = $_POST['Price'];
						$article = $_POST['article'];
						$qty = $_POST['qty'];
						$date = $_POST['date'];
						$pname = $_POST['pname'];
						$Price = $_POST['Price'];
						for ($i = 0; $i < $qty; $i++) {
							if (isset($kode)) : echo $kode;
							endif;
					?>

							<div style="padding:2.5px 3px;float: left; height: 104.72px; width: 135.3px; border: 1px solid #ddd;">
								<div style="width: 134.5px; text-align: center; float: right;">
									<p class="article" style="font-size: 12px;"><?php echo $article; ?></p>
									<p style="font-size: 12px; text-align: center; margin:4px 0;line-height: 1;"><?php echo $pname; ?></p>
									<img src='<?php echo site_url(); ?>GenerateBarcode/<?php echo $PID; ?>' style="height: 35px; width: 108px;" /><br>
									<p style="margin:0;text-align: center;"><?php echo $this->session->userdata('Currency_Name') . ' ' . $Price; ?></p>
								</div>
							</div>
					<?php }
					} ?>

				</section>
			</div>
		</div>

	</div>
</body>

</html>