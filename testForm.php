<?php

include('testconfig.php');
include('testFunctions.php');

$listingID = get('listingid');
$propertyID = get('propertyid');
$action = get('action');
$type = get('type');
$property = null;
$listing = null;

if ($action == 'edit' && $type == 'property') {
    $sql = "
           SELECT *
           FROM properties
           WHERE property_ID = :propertyID
            ";
    $params = array(
        'propertyID' => $propertyID);
    $statement = $dbh->prepare($sql);
    $statement->execute($params);
    $properties = $statement->fetchAll(PDO::FETCH_ASSOC);
    $property = $properties[0];
}
if ($action == 'edit' && $type == 'listing') {
    $sql = "
           SELECT *
           FROM listings
           WHERE property_ID = :propertyID
            ";
    $params = array(
        'propertyID' => $propertyID);
    $statement = $dbh->prepare($sql);
    $statement->execute($params);
    $listings = $statement->fetchAll(PDO::FETCH_ASSOC);
    $listing = $listings[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $propertyID = $_POST['property_id'];
    if ($type == 'property') {
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $county = $_POST['county'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $pool = $_POST['pool'];
}
    else if ($type == 'listing') {
        $price = $_POST['price'];
        $date = $_POST['list_date'];
        $listingID = $_POST['listing_id'];
        $sellerID = $_POST['seller_id'];
    }
    if ($action == 'edit' && $type == 'property') {
        $sql = "UPDATE properties
            SET street_address = :address,
            city = :city,
            state = :state,
            zip = :zip,
            county = :county,
            bedrooms = :bedrooms,
            bathrooms = :bathrooms,
            pool = :pool
            WHERE property_ID = :propertyid
            ";
        $params = array(
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'county' => $county,
            'bedrooms' => $bedrooms,
            'bathrooms' => $bathrooms,
            'pool' => $pool,
            'propertyid' => $propertyID
        );
        $statement = $dbh->prepare($sql);
        if (!$statement->execute($params)) {
            echo "Execute failed:";
        }
    }

    else if($action == 'edit' && $type == 'listing') {
        $sql = "
            UPDATE listings
            SET list_date = :listdate,
            price = :price,
            seller_id = :sellerid
            WHERE listing_id = :listingid
            ";
        $params = array(
            'listdate' => $date,
            'price' => $price,
            'sellerid' => $sellerID,
            'listingid' => $listingID
        );
        $statement = $dbh->prepare($sql);
        if (!$statement->execute($params)) {
            echo "Execute failed:";

        }
    }
         else if($action == 'add' && $type == 'property') {
             $sql = "INSERT INTO properties
                    VALUES(:propertyid,
                    :address,
                    :city,
                    :state,
                    :zip,
                    :county,
                    :bedrooms,
                    :bathrooms,
                    :pool)
            ";
             $params = array(
                 'propertyid' => $propertyID,
                 'address' => $address,
                 'city' => $city,
                 'state' => $state,
                 'zip' => $zip,
                 'county' => $county,
                 'bedrooms' => $bedrooms,
                 'bathrooms' => $bathrooms,
                 'pool' => $pool,
             );
             $statement = $dbh->prepare($sql);

             if (!$statement->execute($params)) {
                 echo "Execute failed:";
             }
         }
             else if ($action == 'add' && $type == 'listing') {
             $sql = "INSERT INTO listings
                    VALUES(:listingid, :propertyid, :listdate, :price, :sellerid)
            ";
             $params = array(
                 'propertyid' => $propertyID,
                 'listdate' => $date,
                 'price' => $price,
                 'sellerid' => $sellerID,
                 'listingid' => $listingID
             );
             $statement = $dbh->prepare($sql);
                 if (!$statement->execute($params)) {
                     echo "Execute failed:";
                 }
        }

   header("Location: testindex.php");
}


?>

<head>
    <style>
        form  { display: table;      }
        label { display: table-row; }
        input { display: table-cell; }
    </style>
</head>
<body>
<a href="testIndex.php" >Search Properties</a>
<?php if($type == 'property') : ?>
<form action="" method="POST">
        <label>Property ID</label>
        <input type="text" name="property_id" class="textbox" value="<?php echo $property['PROPERTY_ID'] ?>" />
        <label>Address</label>
        <input type="text" name="address" class="textbox" value="<?php echo $property['STREET_ADDRESS'] ?>" />
        <label>City</label>
        <input type="text" name="city" class="textbox" value="<?php echo $property['CITY'] ?>" />
        <label>State</label>
        <input type="text" name="state" class="textbox" maxlength="2" value="<?php echo $property['STATE'] ?>" />
        <label>Zip</label>
        <input type="number" name="zip" class="textbox" value="<?php echo $property['ZIP'] ?>" />
        <label>County</label>
        <input type="text" name="county" class="textbox" value="<?php echo $property['COUNTY'] ?>" />
        <label>Bedrooms</label>
        <input type="number" name="bedrooms" class="textbox" value="<?php echo $property['BEDROOMS'] ?>" />
        <label>Bathrooms</label>
        <input type="number" name="bathrooms" class="textbox" value="<?php echo $property['BATHROOMS'] ?>" />
        <label>Pool</label>
        <input type="number" name="pool" class="textbox" value="<?php echo $property['POOL'] ?>" />

<br/><br/>
    <input type="submit" class="button" />&nbsp;
    <input type="reset" class="button" />
</form>
    <?php endif; ?>

<?php if($type == 'listing') : ?>
<form action="" method="POST">
    <label>Property_ID</label>
    <input type="text" name="property_id" class="textbox" value="<?php echo $listing['PROPERTY_ID'] ?>" />
    <label>Listing_ID</label>
    <input type="text" name="listing_id" class="textbox" value="<?php echo $listing['LISTING_ID'] ?>" />
    <label>List_Date</label>
    <input type="text" name="list_date" class="textbox" value="<?php echo $listing['LIST_DATE'] ?>" />
    <label>Price</label>
    <input type="number" step="any" name="price" class="textbox" value="<?php echo $listing['PRICE'] ?>" />
    <label>Seller_ID</label>
    <input type="number" step="any" name="seller_id" class="textbox" value="<?php echo $listing['SELLER_ID'] ?>" />
    <br /><br />
    <input type="submit" class="button" />&nbsp;
    <input type="reset" class="button" />
</form>
<?php endif; ?>
</body>