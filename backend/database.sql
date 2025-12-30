CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  role ENUM('USER','ORGANIZER','ADMIN') NOT NULL,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE matches (
  id INT AUTO_INCREMENT PRIMARY KEY,
  organizer_id INT NOT NULL,
  team_home VARCHAR(100) NOT NULL,
  team_away VARCHAR(100) NOT NULL,
  match_date DATE NOT NULL,
  match_time TIME NOT NULL,
  location VARCHAR(150) NOT NULL,
  status ENUM('PENDING','APPROVED') DEFAULT 'PENDING',

  FOREIGN KEY (organizer_id) REFERENCES users(id)
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  match_id INT NOT NULL,
  name VARCHAR(50) NOT NULL,
  price DECIMAL(8,2) NOT NULL,

  FOREIGN KEY (match_id) REFERENCES matches(id)
);

CREATE TABLE tickets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  match_id INT NOT NULL,
  category_id INT NOT NULL,
  seat_number INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (match_id) REFERENCES matches(id),
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  match_id INT NOT NULL,
  comment TEXT,
  rating INT CHECK (rating BETWEEN 1 AND 5),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (match_id) REFERENCES matches(id)
);
