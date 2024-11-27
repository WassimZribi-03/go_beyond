<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Culturelle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:white;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color:#16172d;
            color: black;
            padding: 10px 20px;
            text-align: center;
        }

        
        .content {
            margin: 20px;
        }
        .activity-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }.logo1{
            
            position:absolute;
            top:10px;
            left:10px;
            width: 100px;px; 
            background-color: rgb(248, 242, 242);

        }
        .logo{
           height: fit-content;
        }
        h1{
            background-color: #16172d;
            color:#ffc977;
        }
        a{
            color: white;
            margin-left: 100px;
            
        }
        .activity:hover {
            transform: scale(1.05);}
        .activity {
            width: 150px;
            height: 250px;
        
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            color: white;
            position: relative;
            cursor: pointer;
            transition: transform 0.2s;}
        .activity img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .activity-content {
            background: rgba(0, 0, 0, 0.6);
            padding: 10px;
            text-align: center;
        }
        .activity-title {
            font-size: 16px;
            font-weight: bold;
        }
        .activity h2 {
            margin: 10px 0 0;
            font-size: 16px;
            color: #333;
        }
        .footer-link {
            display: block;
            text-align: center;
            font-size: 18px;
            color: blue;
            text-decoration: none;
            margin: 20px 0;
            .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #333;
            color: white;
        }
       
    
        
    </style>
</head>
<body>
    <header class="header">
        <img src="gobeyond.png" alt="logo1" class="logo1">
        
        <nav class="nav-links">
            <a href="calendrier">Calender</a>
            <a href="recompenses">Récompenses</a>
            <a href="blog">Blog</a>
            <a href="reclamation">Reclamation</a>
        </nav>
    </header>


    <div class="header">
        <h1>Qu'est-ce que vous avez envie de faire ?</h1>
    </div>

    <div class="activity-container">
        <div class="activity">
            <img src="medina.jpeg" alt="medina">
            <h2>Découvrir la Médina</h2>
        </div>
        <div class="activity">
            <img src="jam.jpeg" alt="jam">
            <h2>Découvrir El Jem</h2>
            
        </div>
        <div class="activity">
            <img src="sahara.jpeg" alt="sahara">
            <h2>La Sahara du Sud</h2>
        </div>
        <div class="activity">
            <img src="carthage.jpeg" alt="carthage">
            <h2>Excursion à Carthage</h2>
        </div>
    </div>

    <div class="header">
        <h1>Les meilleurs lieux à visiter</h1>
    </div>

    <div class="activity-container">
        <div class="activity">
            <img src="dareljeld.jpg" alt="dar">
            <h2>Dar El Jeld</h2>
        </div>
        <div class="activity">
            <img src="museebardo.jpg" alt="musée">
            <h2>Musée du Bardo</h2>
        </div>
        <div class="activity">
            <img src="djerba.jpeg" alt="djerba">
            <h2>Plages de Djerba</h2>
        </div>
    </div>

    <div class="header">
        <h1>Explorez un nouveau musée</h1>
    </div>

    <div class="activity-container">
        <div class="activity">
            <img src="Carthage1.jpg" alt="carthage">
            <h2>Musée de Carthage</h2>
        </div>
        <div class="activity">
            <img src="sousse.jpeg" alt="sousse">
            <h2>Musée de Sousse</h2>
        </div>
    </div>

    <div class="header">
        <h1>Préparez-vous à explorer...</h1>
    </div>

    <div class="activity-container">
        <div class="activity">
            <img src="jerid.jpeg" alt="jerid">
            <h2>Chott el Jerid</h2>
        </div>
        <div class="activity">
            <img src="djerba.jpeg" alt="djerba">
            <h2>Plages de Djerba</h2>
        </div>
    </div>

    <div class="header">
        <h1>Recommandé pour vous</h1>
    </div>

    <div class="activity-container">
        <div class="activity">
            <img src="car.jpeg" alt="car">
            <h2>Explorer la Tunisie Antique</h2>
        </div>
        <div class="activity">
            <img src="hamma.jpeg" alt="hamma">
            <h2>Détente sur les Plages Méditerranéennes</h2>
        </div>
    </div>
    <a href="Continuez" class="footer-link">Continuez à explorer</a>

</body>
</html>