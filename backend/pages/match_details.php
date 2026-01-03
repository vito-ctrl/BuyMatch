<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';
require_once '../classes/SportMatch.php';

$match_id = (int) ($_GET['id'] ?? 0);

$db = new Database();
$pdo = $db->connect();

$Match_Organizer = SportMatch::getMatchAndOrganizer($pdo, $match_id);
$Match_Category = SportMatch::getCategory($pdo, $match_id);
$Match_Comments = SportMatch::getCommets($pdo, $match_id);
$Match_Tickets = SportMatch::getTickets($pdo, $match_id);

if (!$Match_Organizer) {
    die("Match not found or not approved.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($Match_Organizer['title']) ?> | BuyMatch</title>
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(120deg, #0f172a, #1e293b);
        color: #e2e8f0;
        display: flex;
        justify-content: center;
        padding: 50px 20px;
    }

    .card {
        background: #1e293b;
        border-radius: 20px;
        max-width: 650px;
        width: 100%;
        box-shadow: 0 15px 30px rgba(0,0,0,0.6);
        padding: 35px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.7);
    }

    h1 {
        color: #38bdf8;
        font-size: 28px;
        margin-bottom: 20px;
        text-shadow: 1px 1px 2px #0f172a;
    }

    .info {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
    }

    .info p {
        margin: 0;
        font-size: 15px;
    }

    .label {
        color: #facc15;
        font-weight: bold;
    }

    .buy-btn {
        margin-top: 25px;
        width: 100%;
        padding: 12px 0;
        background-color: #38bdf8;
        color: #020617;
        font-weight: bold;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .buy-btn:hover {
        background-color: #0ea5e9;
    }

    .comment {
        margin-top: 20px;
        padding: 15px;
        background-color: #0f172a;
        border-left: 5px solid #38bdf8;
        border-radius: 10px;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.3);
    }

    .comment p {
        margin: 5px 0;
        font-size: 14px;
    }

    .tickets {
        margin-top: 20px;
        padding: 12px;
        background-color: #334155;
        border-radius: 12px;
        text-align: center;
        font-weight: bold;
        color: #facc15;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.3);
    }
</style>
</head>
<body>

<div class="card">
    <h1><?= htmlspecialchars($Match_Organizer['title']) ?></h1>

    <div class="info">
        <p><span class="label">Description:</span> <?= htmlspecialchars($Match_Organizer['description']) ?></p>
        <p><span class="label">Date:</span> <?= date('d M Y - H:i', strtotime($Match_Organizer['match_date'])) ?></p>
        <p><span class="label">Location:</span> <?= htmlspecialchars($Match_Organizer['location']) ?></p>
        <p><span class="label">Organizer:</span> <?= htmlspecialchars($Match_Organizer['organizer_name']) ?> (<?= htmlspecialchars($Match_Organizer['organizer_email']) ?>)</p>
        <?php if ($Match_Category): ?>
            <p><span class="label">Category:</span> <?= htmlspecialchars($Match_Category['name']) ?> - $<?= number_format($Match_Category['price'], 2) ?></p>
        <?php endif; ?>
    </div>

    <div class="tickets">
        Tickets Sold: <?= $Match_Tickets['total_tickets'] ?? 0 ?>
    </div>

    <?php if ($Match_Comments): ?>
        <div class="comment">
            <p><strong><?= htmlspecialchars($Match_Comments['user_name']) ?>:</strong> <?= htmlspecialchars($Match_Comments['content']) ?></p>
            <p style="font-size: 12px; color:#94a3b8;"><?= date('d M Y H:i', strtotime($Match_Comments['created_at'])) ?></p>
        </div>
    <?php endif; ?>

    <button class="buy-btn">Buy Ticket</button>
</div>

</body>
</html>
