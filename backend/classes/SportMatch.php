<?php
    require_once "../config/database.php";

    class SportMatch {
        public static function getAllApproved($pdo) {
            $sql = "SELECT id, title, description, match_date, location
                    FROM matches
                    WHERE status = 'approved'
                    ORDER BY match_date ASC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function getMatchAndOrganizer ($pdo, $match_id) {
            $sql = "SELECT 
                            m.id,
                            m.title,
                            m.description,
                            m.match_date,
                            m.location,
                            m.status,
                            u.name AS organizer_name,
                            u.email AS organizer_email
                        FROM matches m
                        JOIN users u ON m.organizer_id = u.id
                        WHERE m.id = :match_id
                        AND m.status = 'approved';
                    ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':match_id' => $match_id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public static function getCategory($pdo, $match_id) {
            $sql = "SELECT 
                    id,
                    name,
                    price
                FROM categories
                WHERE match_id = :match_id;";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':match_id' => $match_id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public static function getCommets($pdo, $match_id) {
            $sql = "SELECT 
                        c.id,
                        c.content,
                        c.created_at,
                        u.name AS user_name
                    FROM comments c
                    JOIN users u ON c.user_id = u.id
                    WHERE c.match_id = :match_id
                    ORDER BY c.created_at DESC";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':match_id' => $match_id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public static function getTickets($pdo, $match_id) {
            $sql = "SELECT total_tickets
                        FROM tickets_per_match
                        WHERE match_id = :match_id;
                    ";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':match_id' => $match_id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

    }
?>