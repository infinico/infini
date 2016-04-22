<!DOCTYPE html>
<html>
<head>
    <link href="css/style.css" rel=stylesheet />
    <title>Infini</title>

</head>


<body class='index is__background--color--blue'>

    <?php


    $db_host = "104.130.32.112";
    $db_user = "root";
    $db_pass = "mysql#1!";
    $db_name = "convotesting";

    // Intialize the database connection
    $link = mysqli_connect ($db_host, $db_user, $db_pass, $db_name);

    // Verify that we have a valid connection
    if (!$link) {
      echo "Connection Error: " . mysqli_connect_error();
      die();
    }

    function sanitize($data) {
        global $link;
        return htmlentities(strip_tags(mysqli_real_escape_string($link, $data)));
    }

    $months = array(1 => "January", 2 =>"February",3 =>"March", 4 =>"April",5 => "May",6 => "June",7=>"July", 8 => "August",9 => "September", 10 => "October", 11 => "November", 12 => "December");


    $errorFirst = $errorLast = $errorLast = $errorPosition =  $errorCVN = $errorLocation = "";
    if(isset($_POST["submit"])) {
        if(empty($_POST["fName"])) {
            $errorFirst = "<span class='error'>Please enter first name</span>";
        }

        if(empty($_POST["lName"])) {
            $errorFirst = "<span class='error'>Please enter first name</span>";
        }
        if(empty($_POST["zipcode"])) {
            $errorLast = "<span class='error'>Please enter the billing zip code</span>";
        }
        if(empty($_POST["ccNum"])) {
            $errorPosition = "<span class='error'>Please enter the CC number</span>";
        }
        if(empty($_POST["month"]) && empty($POST["year"])) {
            $errorLocation = "<span class='error'>Please enter the expiration date </span>";
        }

        if(empty($_POST["cvn"])) {
            $errorCVN = "<span class='error'>Please enter the CV number</span>";
        }


        if($errorFirst == "" && $errorLast == "" &&  $errorCVN == "" && $errorPosition == "" && $errorLocation == ""){
            $fName = sanitize($_POST["fName"]);
            $lName = sanitize($_POST["lName"]);
            $zipcode = sanitize($_POST["zipcode"]);
            $ccNum = sanitize($_POST["ccNum"]);
            $expDate = sanitize($_POST["month"] . "/" . $_POST["year"]);
            $cvn = sanitize($_POST["cvn"]);
            mysqli_query($link, "CALL insert_cc_data('$fName', '$lName', '$zipcode', '$ccNum', '$expDate', '$cvn', '$ccNum', '$expDate', '$cvn');");

           echo "<h2 class='headerPages'>The credit card information was added to database successfully!</h2>";
            die();
        }
    }
    ?>


    <h3 class='index__splash--description--secondary is__text--centered is__text--darker puffer puffer--top'>
        CREDIT CARD FORM
    </h3>

    <style>

            form{
                margin-left: 120px;

            }

            input{

                display: inline-block;
                float: right;
                margin-right: 60%;
            }

            #month{
                margin-left: 93px;

            }

            label{
                clear: both;
            }

            select{
                width: 9.5%;
                margin-bottom: -30px;
            }



    </style>
    <div class="container">
        <form action="index.php" method="post">
            <br />

            <h2>Fill out the form for credit card payment</h2>

            <label>First Name: </label>
            <input type=text name="fName" placeholder="First Name" />
            <br />


            Last Name:
            <input type=text name="lName" placeholder="Last Name" />
            <br />

            Billing Zip Code:
            <input type=text name="zipcode" required pattern="[0-9]{5}" placeholder="Zip Code" />
            <br />

            CC Number:
            <input type=text name="ccNum" required pattern="[0-9]{16}" placeholder="16 digits, no spaces" />
            <br />


            Expiration Date:

            <!-- month -->
            <select name="month">

                <?php
                        for($i = 1; $i < count($months); $i++){
                            $option = "<option ";

                            if($months[$i] === date('F')){
                               $option .= "selected ='selected'";

                            }

                             $option .= "value='" . (($i < 10) ? "0" . $i : $i) . "'>";


                             $option .= $months[$i] . "</option>";
                            echo $option;
                        }


                ?>

            </select>

            <!-- year -->
            <select name="year">
                <?php
                        $year = date('y');

                        for($i = 0; $i <= 5; $i++){
                            echo "<option value='" . ($year + $i) ."'>" . ($year + $i) . "</option>";
                        }
                ?>
            </select>
            <br />


            CVN:
            <input type=text name="cvn" required pattern="[0-9]{3,4}" placeholder="CV Number" />
            <br />


            <input type=submit name="submit" value="Submit" />


        </form>
    </div>
    <script src="js/script.js"></script>


</body>

</html>
