<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="assets/style.css" type="text/css">
</head>
<body>

<h1>#BRUUT</h1>
<p>bar/restaurant</p>

<div class="Bonnetje">

    <?php

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "bonnetje";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM bon;";
    $result = $conn->query($sql);

	$totaalPrijs = 0;
	$totaalZonderAlcohol = 0;
	$totaalAlcohol = 0;
	
    if ($result->num_rows > 0) {
    $table = $result->fetch_assoc();

    ?>
    <p style="font-size: 13px">Tafel: <?php echo $table['tafelnummer'] ?></p>
    <p style="font-size: 13px"><?php echo $table['printdatum'] ?></p>
    <p style="font-size: 13px">bediend door: <?php echo $table['bediende'] ?></p>
    <table>

        <hr>
        <tr>
            <th>aantal</th>
            <th>Omschrijving</th>
            <th>prijs</th>
        </tr>

        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>" .
                "<td>" . $row["aantal"] . "</td> " .
                "<td>" . $row["omschrijving"] . "</td> " .
                "<td class='prijs'>" . $row["prijsperstuk"] . "</td>" .
                "</tr>";

		
            $totaalPrijs += $row['prijsperstuk'];

            switch ($row['btw']) {
                case 9:
                    $btwProcent = 9;
                    $totaalZonderAlcohol += $row['prijsperstuk'] * $row['aantal'];
                    break;
                case 21:
                    $btwProcent = 21;
                    $totaalAlcohol += $row['prijsperstuk'] * $row['aantal'];
                    break;
            }
        }
        } else {
            echo "0 results";
        }
        ?>
    </table>
    <hr>
    <h3>Totaal: <?php echo $totaalPrijs; ?></h3>
    <hr>
    <hr>
    <table>
        <tr>
            <th>BTW%</th>
            <th>BTW</th>
            <th>Exl.</th>
            <th>Incl.</th>
        </tr>
        <tr>
            <td>9%</td>
            <td><?php echo $totaalZonderAlcohol / 100 * 9 ?></td>
            <td><?php echo $totaalZonderAlcohol ?></td>
            <td><?php echo $totaalZonderAlcohol * 1.09 ?></td>
        </tr>
        <tr>
            <td>21%</td>
            <td><?php echo $totaalAlcohol / 100 * 21 ?></td>
            <td><?php echo $totaalAlcohol ?></td>
            <td><?php echo $totaalAlcohol * 1.21 ?></td>
        </tr>
    </table>
    <hr>
</div>

</body>
</html>

<?php $conn->close(); 

?>
<style>
body{
	width: 20%;
	margin: 0 auto;
}

Bonnetje{
	
}



</style>