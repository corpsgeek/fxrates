
    <?php
// Turn off all error reporting
error_reporting(0);

if (isset($_POST['ratesget'])) {
    if (isset($_POST['currency-pair'])) {
        $selected_pair = $_POST['currency-pair'];
    }
}

$req_url = "https://www.freeforexapi.com/api/live?pairs=$selected_pair";
$response_json = file_get_contents($req_url);


// Continuing if we got a result
if (false !== $response_json) {

    // Try/catch for json_decode operation
    try {

        // Decoding JSON object
        $response_object = json_decode($response_json);
        $price = $response_object->rates->$selected_pair->rate;
    } catch (Exception $e) {
        // Handle JSON parse error...
    }
} else {
    echo "<script>alert('Could not fetch rates, please refresh')</script>";
}

?>


<!DOCTYPE html>
<html lang="en">
<!-- Credit to israel obiagba for the frontend design-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css\main.css" type="text/css" rel="stylesheet" />
    <title><?php echo "Currency Converter" ?></title>
</head>

<body>
<main class="container">
        <form method="POST" action="">
            <section class="boxes">

                <div class="box box-left">
                    <h4 class="app-title">Forex &nbsp;Rates</h4>
                    <div class="app-info">
                        <p class="small-text">Exchange Rate</p>
                        <h1 class="main-text">
<?php echo $price; ?></h1>

                    </div>
                </div>
                <div class="box box-right">
                    <div class="currency-btn-group">
                        <!-- <div class="input-group">
                            <label for="input-currency" class="label small-text">enter amount</label>
                            <input type="text" class="text-field" id="input-currency" name="amount_to_convert">
                        </div> -->
                        <div class="input-group">
                            <label for="input-currency" class="label small-text">from</label>
                            <select name="currency-pair" class="currency-names" id="currency-from">
                            <?php 
                            if (isset($_POST['ratesget'])) {
                                if (isset($_POST['currency-pair'])) {
                                    $selected_pair = $_POST['currency-pair'];
                             
                            
                            ?>   
                            <option value="<?php echo $selected_pair; ?>"><?php echo $selected_pair; ?></option>

                            <?php 
                                   }
                                }
                            ?>
                                <?php
                                $req_url = 'https://www.freeforexapi.com/api/live';
                                $response_json = file_get_contents($req_url);



                                // Continuing if we got a result
                                if (false !== $response_json) {

                                    // Try/catch for json_decode operation
                                    try {

                                        // Decoding JSON object
                                        $response_object = json_decode($response_json);
                                        // print_r($response_object);
                                        $var = array($response_object->supportedPairs);
                                        foreach ($var as $denom) {

                                            foreach ($denom as $key => $value) {


                                                ?>
                                                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                            <?php
                                        }
                                    }
                                } catch (Exception $e) {
                                    // Handle JSON parse error...
                                }
                            } ?>
                            </select>
                        </div>
                        <!-- <div class="input-group">
                            <label for="currency-to" class="label small-text">to</label>
                            <select name="currency-to" class="currency-names" id="currency-to">
                                <option value="--">select a currency</option>
                                <option value="dollar">dollar</option>
                                <option value="naira">naira</option>
                            </select>
                        </div> -->
                        <div class="input-group">
                            <input type="submit" value="Get Rates" name="ratesget" class="currency-btn small-text" />
                        </div>
                    </div>
                </div>
            </section>
        </form>
    </main>
</body>

</html>