<?php
    include __DIR__ . "\header.php";
    $_SESSION['role'] = "pro";
?>

<main id="main" class="container">
    <div class="row">
        <div class="card w-100">
            <div class="card-header">
                <h3 class="card-title">Mon compte</h3>
            </div>
            <form class="card-body"method='POST' action='profil' enctype='multipart/form-data'>
                <div class="d-flex" id="identityLabel">
                    <?php
                        if (isset($_SESSION['role']) && $_SESSION['role'] == "pro") {
                            echo '
                                <img src="placeholder.jpg" class="img-fluid" alt="Photo de profil">
                            ';
                        }
                        if (isset($_SESSION['role']) && $_SESSION['role'] == "particulier") {
                            echo '
                                <span class="input-group-text"><i class="bi bi-person-square"></i></span>
                            ';
                        }
                    ?>
                    <label class="col-2 form-label">Nom</label>
                    <label class="col-2 form-label">Prénom</label>
                </div>
                <?php
                    if (isset($_SESSION['role']) && $_SESSION['role'] == "pro") {
                        echo '
                            <div>
                                <input type="file" class="form-control" id="inputImage" accept="image/*">
                            </div>
                        ';
                    }
                ?>
                <div class="d-flex">
                    <label class="col-2 form-label">Anniversaire</label>
                    <input type="text" class="form-control" id="datepicker" name="inputBirthday" placeholder="Sélectionner une date ..."/>
                    <span class="input-group-text" id="calendarIcon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                </div>
                <?php
                    if (isset($_GET["birthdayEmptyError"])) {
                        echo '
                            <div class="alert alert-danger" role="alert">
                                Ce champs est obligatoire
                            </div>
                        ';
                    }
                ?>
                <div class="d-flex">
                    <label class="col-2 form-label">Email</label>
                    <input type="email" class="form-control col-10" name="inputEmail" placeholder="Entrez votre email ..."/>
                </div>
                <?php
                if (isset($_GET["emailEmptyError"])) {
                    echo '
                            <div class="alert alert-danger" role="alert">
                                Ce champs est obligatoire
                            </div>
                        ';
                } else if (isset($_GET["emailSyntaxError"])) {
                    echo '
                            <div class="alert alert-danger" role="alert">
                                L\'adresse mail est mal renseignée
                            </div>
                    ';
                }

                if (isset($_SESSION['role']) && $_SESSION['role'] == "pro") {
                    echo '
                        <div class="d-flex">
                            <label class="col-2 form-label">Téléphone</label>
                            <input type="tel" class="form-control col-10" name="inputPhone" placeholder="Entrez votre numéro de téléphone ..."/>
                        </div>
                    ';

                    if (isset($_GET["phoneSyntaxError"])) {
                        echo '
                                <div class="alert alert-danger" role="alert">
                                    Le numéro de téléphone est mal renseigné
                                </div>
                        ';
                    }

                    echo '
                        <div class="d-flex">
                            <label class="col-2 form-label">Métier</label>
                            <input type="text" class="form-control" name="inputJob" placeholder="Entrez votre métier ..."/>
                        </div>
                    ';

                    if (isset($_GET["jobEmptyError"])) {
                        echo '
                            <div class="alert alert-danger" role="alert">
                                Ce champs est obligatoire
                            </div>
                        ';
                    }

                    echo '
                        <div class="d-flex">
                            <label class="col-2 form-label">Spécialités</label>
                            <textarea type="text" class="form-control" name="inputSpecialties" placeholder="Entrez vos spécialités ..."></textarea>
                        </div>
                        <div class="d-flex">
                            <label class="col-2 form-label">Diplômes</label>
                            <textarea type="text" class="form-control" name="inputDiplomas" placeholder="Entrez vos diplômes ..."></textarea>
                        </div>
                        <div class="d-flex">
                            <label class="col-2 form-label">Description</label>
                            <textarea type="text" class="form-control" name="inputDescription" placeholder="Entrez votre description ..."></textarea>
                        </div>
                        <div class="d-flex">
                            <label class="col-2 form-label">Tarifs</label>
                            <textarea type="text" class="form-control" name="inputDescription" placeholder="Entrez vos tarifs ..."></textarea>
                        </div>
                        <div class="d-flex">
                            <label class="col-2 form-label">Adresse</label>
                            <div class="w-100" id="divAdress">
                                <input type="text" class="form-control" name="inputCountry" placeholder="Entrez votre pays ..."/>
                    ';

                    if (isset($_GET["countryEmptyError"])) {
                        echo '
                            <div class="alert alert-danger" role="alert">
                                Ce champs est obligatoire
                            </div>
                        ';
                    }

                    echo '
                                <input type="text" class="form-control" name="inputCity" placeholder="Entrez votre ville ..."/>
                    ';

                    if (isset($_GET["cityEmptyError"])) {
                        echo '
                            <div class="alert alert-danger" role="alert">
                                Ce champs est obligatoire
                            </div>
                        ';
                    }

                    echo '
                                <input type="text" class="form-control" name="inputPostalCode" maxlength="5" pattern="\d{5}" placeholder="Entrez votre code postal ...">
                    ';

                    if (isset($_GET["postalCodeEmptyError"])) {
                        echo '
                            <div class="alert alert-danger" role="alert">
                                Ce champs est obligatoire
                            </div>
                        ';
                    } else if (isset($_GET["postalCodeSyntaxError"])) {
                        echo '
                                <div class="alert alert-danger" role="alert">
                                    Le code postal est un numéro à 5 chiffres
                                </div>
                                ';
                    }

                    echo '
                                <input type="text" class="form-control" name="inputAdress" placeholder="Entrez votre adresse ..."/>
                            </div>
                        </div>
                        <div class="d-flex">
                            <label class="col-2 form-label">Disponibilités</label>
                            <div class="col-10">
                                <div class="d-flex">
                                    <label class="col-2 form-label">Lundi</label>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">De</label>
                                        <input class="col-7" type="time" name="inputTimeMondayStart">
                                    </div>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">à</label>
                                        <input class="col-7" type="time" name="inputTimeMondayEnd">
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <label class="col-2 form-label">Mardi</label>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">De</label>
                                        <input class="col-7" type="time" name="inputTimeTuesdayStart">
                                    </div>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">à</label>
                                        <input class="col-7" type="time" name="inputTimeMondayEnd">
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <label class="col-2 form-label">Mercredi</label>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">De</label>
                                        <input class="col-7" type="time" name="inputTimeWednesdayStart">
                                    </div>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">à</label>
                                        <input class="col-7" type="time" name="inputTimeMondayEnd">
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <label class="col-2 form-label">Jeudi</label>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">De</label>
                                        <input class="col-7" type="time" name="inputTimeThursdayStart">
                                    </div>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">à</label>
                                        <input class="col-7" type="time" name="inputTimeMondayEnd">
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <label class="col-2 form-label">Vendredi</label>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">De</label>
                                        <input class="col-7" type="time" name="inputTimeFridayStart">
                                    </div>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">à</label>
                                        <input class="col-7" type="time" name="inputTimeMondayEnd">
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <label class="col-2 form-label">Samedi</label>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">De</label>
                                        <input class="col-7" type="time" name="inputTimeSaturdayStart">
                                    </div>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">à</label>
                                        <input class="col-7" type="time" name="inputTimeMondayEnd">
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <label class="col-2 form-label">Dimanche</label>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">De</label>
                                        <input class="col-7" type="time" name="inputTimeSundayStart">
                                    </div>
                                    <div class="d-flex col-4">
                                        <label class="col-5 form-label">à</label>
                                        <input class="col-7" type="time" name="inputTimeMondayEnd">
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                    }
                ?>
                <div class="form-button d-flex justify-content-between">
                    <a href="#" class="btn btn-secondary">Modifier mon mot de passe</a>
                    <div class="d-flex justify-content-between">
                        <input type="submit" value="Valider" name="inputValidate" class="btn btn-success"/>
                        <button class="btn btn-danger">Supprimer mon compte</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    $(document).ready(function(){
        $('#datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true
        });
        $('#calendarIcon').click(function(){
            $('#datepicker').datepicker('show');
        });
    });

    function selectImage() {
        var input = document.getElementById('inputImage');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('imageData').value = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
