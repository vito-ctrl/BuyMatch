CREATE DATABASE buymatch;
USE buymatch;

-- USERS TABLE
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('buyer','organizer','admin') DEFAULT 'buyer',
    status ENUM('active','disabled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- MATCHES TABLE
CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    match_date DATETIME NOT NULL,
    location VARCHAR(150),
    organizer_id INT NOT NULL,
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_match_organizer
        FOREIGN KEY (organizer_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

-- CATEGORIES TABLE
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(8,2) NOT NULL,
    match_id INT NOT NULL,

    CONSTRAINT fk_category_match
        FOREIGN KEY (match_id)
        REFERENCES matches(id)
        ON DELETE CASCADE
);

-- TICKETS TABLE
CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    match_id INT NOT NULL,
    category_id INT NOT NULL,
    seat_number VARCHAR(20),
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_ticket_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_ticket_match
        FOREIGN KEY (match_id)
        REFERENCES matches(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_ticket_category
        FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON DELETE CASCADE
);

-- COMMENTS TABLE
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    match_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_comment_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_comment_match
        FOREIGN KEY (match_id)
        REFERENCES matches(id)
        ON DELETE CASCADE
);

-- SQL VIEW Tickets per match
CREATE VIEW tickets_per_match AS
SELECT 
    m.id AS match_id,
    m.title AS match_title,
    COUNT(t.id) AS total_tickets
FROM matches m
LEFT JOIN tickets t ON m.id = t.match_id
GROUP BY m.id;

-- STORED PROCEDURE Total sales per match
DELIMITER //

CREATE PROCEDURE total_sales(IN matchId INT)
BEGIN
    SELECT 
        m.title,
        SUM(c.price) AS total_sales
    FROM tickets t
    JOIN categories c ON t.category_id = c.id
    JOIN matches m ON t.match_id = m.id
    WHERE t.match_id = matchId;
END //

DELIMITER ;


-- fake data to test with
INSERT INTO matches (title, description, match_date, location, organizer_id, status)
VALUES
(
  'Real Madrid vs FC Barcelona',
  'El Clasico – Spanish league showdown',
  '2026-02-10 20:00:00',
  'Santiago Bernabéu Stadium',
  2,
  'approved'
),
(
  'Manchester City vs Arsenal',
  'Premier League top clash',
  '2026-02-15 18:30:00',
  'Etihad Stadium',
  2,
  'approved'
),
(
  'LA Lakers vs Golden State Warriors',
  'NBA regular season game',
  '2026-03-01 21:00:00',
  'Crypto.com Arena',
  2,
  'approved'
);

INSERT INTO categories (name, price, match_id)
VALUES
-- Match 1
('VIP', 80.00, 1),
('Premium', 50.00, 1),
('Standard', 30.00, 1),

-- Match 2
('VIP', 75.00, 2),
('Standard', 35.00, 2),

-- Match 3
('VIP', 90.00, 3),
('Standard', 40.00, 3);

INSERT INTO tickets (user_id, match_id, category_id, seat_number)
VALUES
(1, 1, 3, 'A12'),
(1, 2, 5, 'B07'),
(1, 3, 6, 'VIP-01');

INSERT INTO comments (user_id, match_id, content)
VALUES
(1, 1, 'Amazing atmosphere and great match!'),
(1, 2, 'Very smooth booking experience.'),
(1, 3, 'Totally worth the price!');
