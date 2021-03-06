<?php


include('testconfig.php');
include('testFunctions.php');

$city = get('city');
$bedrooms = get('bedrooms');
$bathrooms = get('bathrooms');

$term = $city . '%';
$term2 = $bedrooms;
$term3 = $bathrooms;

$sql = "
           SELECT properties.PROPERTY_ID, STREET_ADDRESS, CITY, STATE, ZIP, COUNTY, BEDROOMS, BATHROOMS, POOL, PRICE
           FROM properties
           FULL OUTER JOIN listings ON Properties.property_ID = listings.property_ID
           WHERE LOWER(city) LIKE LOWER(:city)
           AND bedrooms >= :bedrooms
           AND bathrooms >= :bathrooms
            ";
$params = array(
    'city' => $term,
    'bedrooms' => $term2,
    'bathrooms' => $term3
);
$statement = $dbh->prepare($sql);
$statement->execute($params);
$properties = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Search Houses</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="SitePoint">

    <link rel="stylesheet" href="css/style.css">

    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
</head>
<body>

<?php if(isAdmin($dbh)) : ?>
    <a href="testForm.php?action=add&type=property" >Add Property</a><br/>
    <a href="testForm.php?action=add&type=listing" >Add Listing</a><br/>
<?php endif; ?>

<form method="GET">
    <input type="text" name="city" placeholder="City" />
    # of Bedrooms: <select name = "bedrooms">
    <?php
    for ($i=1; $i<=10; $i++)
    {
        ?>
        <option value="<?php echo $i;?>"><?php echo $i;?></option>
        <?php
    }
    ?>
    </select>
    # of Bathrooms: <select name = "bathrooms">
        <?php
        for ($i=1; $i<=10; $i++)
        {
            ?>
            <option value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php
        }
        ?>
    </select>
    <input type="submit" />
</form>


<?php foreach($properties as $property) : ?>
    <p>
        <?php echo $property['STREET_ADDRESS']; ?><br />
        <?php echo $property['CITY'] . ', ' . $property['STATE'] . ' ' . $property['ZIP'] ; ?> <br />
        County: <?php echo $property['COUNTY']; ?> <br />
        Bedrooms: <?php echo $property['BEDROOMS']; ?> <br />
        Bathrooms: <?php echo $property['BATHROOMS']; ?> <br />
        Pool: <?php echo $property['POOL']; ?><br/>
        <?php if(isset($property['PRICE'])) : ?>
        Price: <?php echo $property['PRICE'] ?><br />
            <?php if(isAdmin($dbh)) : ?>
                <a href="testform.php?action=edit&type=listing&propertyid=<?php echo $property['PROPERTY_ID'] ?>">Edit Listing</a><br />
        <?php endif; endif; ?>



        <?php if(isAdmin($dbh)) : ?>
        <a href="testform.php?action=edit&type=property&propertyid=<?php echo $property['PROPERTY_ID'] ?>">Edit Property</a><br />
        <?php endif ?>
    </p>
<?php endforeach; ?>

<a href="test.php">Logout</a>

</body>
</html>
  