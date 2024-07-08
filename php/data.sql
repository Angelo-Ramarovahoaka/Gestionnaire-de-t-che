DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS group_users;
DROP TABLE IF EXISTS group_events;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    image TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    status BOOLEAN DEFAULT FALSE,
    start_date DATE ,
    start_time TIME,
    end_date DATE,
    end_time TIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    status BOOLEAN DEFAULT FALSE,   
    start_time TIME,
    end_time TIME,
    task_date DATE,
    FOREIGN KEY (event_id) REFERENCES events(id)
);

CREATE TABLE group_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id)
);

CREATE TABLE group_users (
    group_id INT,
    user_id INT,
    role ENUM('member', 'admin') DEFAULT 'member',
    PRIMARY KEY (group_id, user_id),
    FOREIGN KEY (group_id) REFERENCES group_events(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
