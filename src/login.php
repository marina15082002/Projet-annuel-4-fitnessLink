<?php include __DIR__ . "\header.php";?>

<link rel="stylesheet" href="/PA/src/css/style.css">

<main>
    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background-image: url('/PA/src/imgs/bg_1.jpg');"></div>
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7">
                        <form method="POST" action="login" enctype="multipart/form-data">
                            <div class="form-group first">
                                <label for="username">Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Entrez votre adresse email" id="username">
                            </div>
                            <div class="form-group last mb-3">
                                <label for="password">Mot de passe</label>
                                <input name="password" type="password" class="form-control" placeholder="Entrez votre mot de passe" id="password">
                            </div>

                            <?php
                            if (isset($_GET["loginError"])) {
                                echo '<div class="alert alert-danger" role="alert">L\'adresse mail ou le mot de passe est incorrect</div>';
                            }
                            ?>
                            <input type="submit" value="Connexion" class="btn btn-block btn-primary" id="btn_login">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>