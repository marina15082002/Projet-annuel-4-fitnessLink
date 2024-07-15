<?php include __DIR__ . "\header.php";?>

<main id="main">
    <div class="row">
        <?php include __DIR__ . "\search_header.php";?>
        <div class="container">
            <div id="profile-professional-page" class="container-fluid">
                <div class="card w-100">
                    <div class="card-header">
                        <img src="<?php echo $user["Profile_photo"]; ?>">
                        <h3 class="card-title">
                            <?php echo $user["Name"] . " " . $user["First_name"]; ?>
                        </h3>
                        <div id="div-profession">
                            <h5 id="profession"><?php echo $user["Profession"] ?></h5>
                            <?php
                            echo '
                                <p>Spécialités : ' . $user["Specialties"] . '</p>
                            ';
                            ?>
                        </div>
                    </div>
                    <div>
                        <a href='../making_appointments/?email=<?php echo urlencode($user['Email']); ?>'>Prendre un rendez-vous</a>
                    </div>
                </div>
                <div id="professional-infos">
                    <div id="professional-infos-describe">
                        <?php
                        if ($user["Description"] != "") {
                            echo '
                                    <div class="div-info" id="div-describe">
                                        <h4><i class="bi bi-person-fill"></i>Présentation</h4>
                                        <p>' . $user["Description"] . '</p>
                                    </div>
                                ';
                        }

                        if ($user["Degrees"] != "") {
                            echo '
                                    <div class="div-info" id="div-degrees">
                                        <h4><i class="bi bi-mortarboard-fill"></i>Diplômes</h4>
                                        <p>' . $user["Degrees"] . '</p>
                                    </div>
                                ';
                        }

                        if ($user["Rates"] != "") {
                            echo '
                                        <div class="div-info" id="div-rates">
                                            <h4><i class="bi bi-currency-euro"></i>Tarifs</h4>
                                            <p>' . $user["Rates"] . '</p>
                                        </div>
                                    ';
                        }

                        ?>
                    </div>
                    <?php
                    if ($user["Country"] != "") {
                            echo '
                                <div class="div-info" id="div-rates">
                                    <h4><i class="bi bi-geo-alt-fill"></i>Lieu</h4>
                                    <p>';
                            echo $user["Country"] . ", " . $user["City"] . ", " . $user["Postal_code"];
                            if ($user["Address"] != "") {
                                echo ", " . $user["Address"];
                            }
                            echo '</p>
                                </div>';
                        }
                    ?>
                    <div class="div-info" id="div-contact">
                        <h4><i class="bi bi-telephone-fill"></i>Contact</h4>
                        <?php
                        echo '
                                    <p> ' . $user["Email"] . '</p>
                                ';
                        if ($user["Phone_number"] != "") {
                            echo '
                                        <p> ' . $user["Phone_number"] . '</p>
                                    ';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php if(isset($_GET['error']) && $_GET['error'] == 1): ?>
        alert("Nous rencontrons actuellement un problème, veuillez réessayer plus tard.");
        <?php endif; ?>
    });
</script>