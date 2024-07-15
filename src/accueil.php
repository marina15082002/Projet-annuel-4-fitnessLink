<?php include __DIR__ . "\header.php";?>

<?php
    if (!empty($_SESSION['Email'])) {
    }
?>

<main id="main">
    <div class="row">
        <?php include __DIR__ . "\search_header.php";?>
        <div class="container">
            <div class="container-fluid">
                <div id="home-page-body">
                    <div id="text-review">
                        <h3>Laissez un avis sur un professionnel</h3>
                        <img src="src/assets/img_home-page/star.png">
                        <img src="src/assets/img_home-page/star.png">
                        <img src="src/assets/img_home-page/star.png">
                        <img src="src/assets/img_home-page/star.png">
                        <img src="src/assets/img_home-page/star.png">
                    </div>
                    <div id="list-profile" class="row">
                        <?php
                            foreach ($users as $user) {
                                echo "
                                    <a href='profil_professionnel/?email=" . urlencode($user['email']) . "' class='col-4'>
                                        <img class='profile_photo' src='". $user['profile_photo'] ."'>
                                        <p class='profession'>". $user['profession'] ."</p>
                                        <p class='price'>". $user['rates'] . "</p>
                                    </a>
                                ";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="div-chatBot">
        <div id="chatBot-header">
            <img src="">
            <label>CoachIA</label>
            <button onclick="openChat()" id="button-open-chatBot"><i class="bi bi-chevron-up"></i></button>
            <button style="display: none" onclick="closeChat()" id="button-close-chatBot"><i class="bi bi-chevron-down"></i></button>
        </div>
        <form class='card-body' method='POST' action='chatbot' enctype='multipart/form-data' style="display: none" id="form-chatBot">
            <p style="color: #696969">CoachIA vous aide à trouver votre coach idéal !</p>
            <div id="div-improve-skill">
                <p>Souhaitez-vous apprendre ou améliorer vos compétences dans un sport spécifique ?</p>
                <input type="hidden" name="inputImproveSkill" id="input-improve-skill"/>
                <div>
                    <button type="button" onclick="nextQuestion(event, 'div-improve-skill', 'input-improve-skill', 'Oui', 'div-losing-weight')">Oui</button>
                    <button type="button" onclick="nextQuestion(event, 'div-improve-skill', 'input-improve-skill', 'Non', 'div-losing-weight')">Non</button>
                </div>
            </div>

            <div id="div-losing-weight" style="display: none">
                <p>Cherchez-vous à perdre du poids ?</p>
                <input type="hidden" name="inputLosingWeight" id="input-losing-weight"/>
                <div>
                    <button type="button" onclick="nextQuestion(event, 'div-losing-weight', 'input-losing-weight', 'Oui', 'div-available-week')">Oui</button>
                    <button type="button" onclick="nextQuestion(event, 'div-losing-weight', 'input-losing-weight', 'Non', 'div-available-week')">Non</button>
                </div>
            </div>

            <div id="div-available-week" style="display: none">
                <p>Êtes-vous disponible pour des séances d'entraînement en semaine ?</p>
                <input type="hidden" name="inputAvailableWeek" id="input-available-week"/>
                <div>
                    <button type="button" onclick="nextQuestion(event, 'div-available-week', 'input-available-week', 'Oui', 'div-budget')">Oui</button>
                    <button type="button" onclick="nextQuestion(event, 'div-available-week', 'input-available-week', 'Non', 'div-budget')">Non</button>
                </div>
            </div>

            <div id="div-budget" style="display: none">
                <p>Quel est votre budget par séance ?</p>
                <input type="hidden" name="inputBudget" id="input-budget"/>
                <div>
                    <button type="button" onclick="nextQuestion(event, 'div-budget', 'input-budget', '>50', 'div-describe-sport-coach')">Moins de 50€</button>
                    <button type="button" onclick="nextQuestion(event, 'div-budget', 'input-budget', '50<70', 'div-describe-sport-coach')">entre 50€ et 70€</button>
                    <button type="button" onclick="nextQuestion(event, 'div-budget', 'input-budget', '<70', 'div-describe-sport-coach')">plus de 70€</button>
                </div>
            </div>

            <div id="div-describe-sport-coach" style="display: none">
                <p>Qu'attendez-vous d'un coach sportif ?</p>
                <input type="hidden" name="inputDescribeSportCoach" id="input-describe-sport-coach"/>
                <textarea id="textarea-describe-sport-coach"></textarea>
                <div class="div-button-validate">
                    <button type="button" onclick="nextQuestion(event, 'div-describe-sport-coach', 'input-describe-sport-coach', 'Valider', 'div-interresant-sporting-activity')">Valider</button>
                </div>
            </div>

            <div id="div-interresant-sporting-activity" style="display: none">
                <p>Quel type d'activité sportive vous intéresse le plus ?</p>
                <input type="hidden" name="inputInterresantSportingActivity" id="input-interresant-sporting-activity"/>
                <textarea id="textarea-interresant-sporting-activity"></textarea>
                <div class="div-button-validate">
                    <button type="button" onclick="nextQuestion(event, 'div-interresant-sporting-activity', 'input-interresant-sporting-activity', 'Valider')">Valider</button>
                </div>
            </div>

            <input type="submit" style="display: none" id="submitButton"/>
        </form>
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php if(isset($_GET['success']) && $_GET['success'] == 1): ?>
            alert("Le rendez-vous a été enregistré avec succès");
        <?php endif; ?>
    });

    function openChat() {
        document.getElementById("form-chatBot").style.display = "flex";
        document.getElementById("button-close-chatBot").style.display = "block";
        document.getElementById("button-open-chatBot").style.display = "none";
    }

    function closeChat() {
        document.getElementById("form-chatBot").style.display = "none";
        document.getElementById("button-close-chatBot").style.display = "none";
        document.getElementById("button-open-chatBot").style.display = "block";
    }

    function nextQuestion(event, divId, inputId, inputValue, nextDivId) {
        event.preventDefault();
        document.getElementById(divId).style.display = 'none';
        if (inputValue !== "Valider") {
            document.getElementById(inputId).value = inputValue;
        } else {
            let idElement = divId.substring(4);
            document.getElementById(inputId).value = document.getElementById("textarea-" + idElement).value;
        }
        if (nextDivId) {
            document.getElementById(nextDivId).style.display = "block";
        } else {
            document.getElementById('submitButton').click();
        }
    }
</script>