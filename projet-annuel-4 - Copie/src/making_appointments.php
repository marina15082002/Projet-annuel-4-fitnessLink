<?php
    include __DIR__ . "\header.php";

    $days = [
        'Monday' => 'Lundi',
        'Tuesday' => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday' => 'Jeudi',
        'Friday' => 'Vendredi',
        'Saturday' => 'Samedi',
        'Sunday' => 'Dimanche'
    ];

    $months = [
        'January' => 'Janvier',
        'February' => 'Février',
        'March' => 'Mars',
        'April' => 'Avril',
        'May' => 'Mai',
        'June' => 'Juin',
        'July' => 'Juillet',
        'August' => 'Août',
        'September' => 'Septembre',
        'October' => 'Octobre',
        'November' => 'Novembre',
        'December' => 'Décembre'
    ];
?>

<main id="main">
    <div class="row">
        <?php include __DIR__ . "\search_header.php";?>
        <div class="container">
            <div id="making-appoitments-page" class="container-fluid">
                <div class="card w-100">
                    <div class="card-header">
                        <h3 class="card-title">Prochains rendez-vous disponibles</h3>
                    </div>
                    <div id="div-making-appoitments">
                        <?php
                        $i = 0;
                        foreach ($availableDays as $index => $date) {
                            $date = explode(" ", $date);
                            $selectedDate = $date[1] . ' ' . $months[$date[2]] . ' ' . $date[3];
                            echo "
                                <form class='card-body' method='POST' action='?email=". urlencode($email) . "' enctype='multipart/form-data'>
                                    <h2>" . $days[$date[0]] . " " . $selectedDate . "</h2>
                                    <input type='hidden' name='selectedDate' value='$selectedDate'> 
                                ";

                                $times = explode(',', $availableTime[$index + 1]);
                                foreach ($times as $time) {
                                    list($start, $end) = explode('-', $time);

                                    $startHour = intval(substr($start, 0, strpos($start, 'h')));
                                    $endHour = intval(substr($end, 0, strpos($end, 'h')));

                                    for ($hour = $startHour; $hour < $endHour; $hour++) {
                                        echo "
                                            <input type='submit' name='inputHour' value='". $hour . "h - " . ($hour + 1) . "h'>
                                            
                                        ";
                                    }
                                }

                                echo "</form>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

