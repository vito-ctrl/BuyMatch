<?php
    require_once "../config/database.php";
    require_once "../classes/SportMatch.php";

    $db = new Database();
    $pdo = $db->connect();

    $matches = SportMatch::getAllApproved($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BuyMatch | Home</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0;
            padding: 30px;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: #e5e7eb;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #38bdf8;
        }

        .matches {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .match-card {
            background-color: #0b1120;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.6);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .match-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 30px rgba(56,189,248,0.4);
        }

        .match-card h3 {
            margin-top: 0;
            color: #38bdf8;
            font-size: 18px;
        }

        .match-card p {
            font-size: 14px;
            margin: 8px 0;
            color: #d1d5db;
        }

        .match-card .date {
            font-weight: bold;
            color: #facc15;
        }

        .match-card a {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 14px;
            background-color: #38bdf8;
            color: #020617;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
        }

        .match-card a:hover {
            background-color: #0ea5e9;
        }

        .empty {
            text-align: center;
            font-size: 16px;
            color: #f87171;
        }
    </style>
</head>
<body>

<h1>Upcoming Matches</h1>

<?php if (empty($matches)): ?>
    <p class="empty">No matches available.</p>
<?php else: ?>
    <div class="matches">
        <?php foreach ($matches as $match): ?>
            <div class="match-card">
                <h3><?= htmlspecialchars($match['title']) ?></h3>
                <p><?= htmlspecialchars($match['description']) ?></p>
                <p class="date">
                    <?= date('d M Y - H:i', strtotime($match['match_date'])) ?>
                </p>
                <p><?= htmlspecialchars($match['location']) ?></p>

                <a href="match_details.php?id=<?= $match['id'] ?>">
                    View Details
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

</body>
</html>
