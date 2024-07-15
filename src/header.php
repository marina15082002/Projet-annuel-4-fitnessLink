<?php
    include __DIR__ . "\head.php";

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

?>

<header id="header">
    <div>
        <div>
            <p>FitnessLink</p>
        </div>
        <div id="headerLinks">
            <?php
                if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
                    echo "
                       <div id='linkAdmin'>
                            <a href='/Projet-annuel-4/admin'>Admin</a>
                       </div> 
                    ";
                }

                if (!isset($_SESSION['email'])) {
                    echo "
                            <div id='linkLogin'>
                                <a href='/Projet-annuel-4/login'>Connexion</a>
                            </div>
                            <div id='linkSignup'>
                                <a href='/Projet-annuel-4/inscription'>Inscription</a>
                            </div>
                        ";
                } else {
                    echo "
                        <div id='linkAppointment'>
                            <a href='/Projet-annuel-4/rendez-vous'>Rendez-vous</a>
                        </div>
                        <div id='linkProfil'>
                            <a href='/Projet-annuel-4/profil'>Profil</a>
                        </div>
                        
                        
                        <div id='linkDisconnect'>
                            <a href='/Projet-annuel-4/deconnexion'>Déconnexion</a>
                        </div>
                        ";
                }
            ?>
        </div>

    </div>
</header>
