<!DOCTYPE html>
<html>

<head>
    <title>Barcode Generator</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        .article {
            min-height: 90px;
            max-height: 100px;
            width: 15px;
            float: left;
            writing-mode: tb-rl;
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
                            <label class="control-label col-xs-2" for="Price">Article </label>
                            <div class="col-xs-2">
                                <input type="text" name="article" class="form-control mytext" placeholder="Article ..." />
                            </div>
                            <input type="hidden" name="purchaseId" class="form-control" value="<?php echo $purchaseId; ?>" placeholder="Article ..." />
                        </div>
                        <div class="form-group">
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
                        $purchaseId = $_POST['purchaseId'];
                        $article = $_POST['article'];
                        $purchases = $this->db->query("SELECT
                                                            p.Product_SlNo,
                                                            p.Product_Code,
                                                            p.Product_Name,
                                                            p.Product_SellingPrice,
                                                            pd.PurchaseDetails_TotalQuantity
                                                        FROM tbl_purchasedetails pd
                                                        LEFT JOIN tbl_product p ON p.Product_SlNo = pd.Product_IDNo
                                                        WHERE pd.Status = 'a' AND pd.PurchaseMaster_IDNo = ?", $purchaseId)->result();
                        foreach ($purchases as $item) {
                            for ($i = 0; $i < $item->PurchaseDetails_TotalQuantity; $i++) {
                                if (isset($kode)) : echo $kode;
                                endif;
                    ?>
                                <div style="padding:2px;float: left; height: 104.6px; width: 135px; border: 1px solid #ddd;">
                                    <div style="width: 135px; text-align: center; float: right;">
                                        <span class="article" style="font-size: 12px;"><?php echo $article; ?></span>
                                        <p style="font-size: 12px; text-align: center; margin:0;"><?php echo $item->Product_Name; ?></p>
                                        <img src='<?php echo site_url(); ?>GenerateBarcode/<?php echo $item->Product_SlNo; ?>' style="height: 50px; width: 100px;" /><br>
                                        <p style="margin:0;margin-top: 5px; text-align: center;"><?php echo $this->session->userdata('Currency_Name') . ' ' . $item->Product_SellingPrice; ?></p>
                                    </div>
                                </div>
                    <?php }
                        }
                    } ?>

                </section>
            </div>
        </div>

    </div>
</body>

</html>