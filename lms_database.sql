-- Create the database
CREATE DATABASE IF NOT EXISTS lms_system;
USE lms_system;

-- Users table (for admin, instructor, student)
CREATE TABLE Users (
                       id INT AUTO_INCREMENT PRIMARY KEY,
                       name VARCHAR(100) NOT NULL,
                       email VARCHAR(100) NOT NULL UNIQUE,
                       password VARCHAR(255) NOT NULL,
                       role ENUM('admin', 'instructor', 'student') NOT NULL,
                       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Categories table (for course categorization)
CREATE TABLE Categories (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(100) NOT NULL UNIQUE,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Courses table (main course information)
CREATE TABLE Courses (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         title VARCHAR(255) NOT NULL,
                         description TEXT NOT NULL,
                         instructor_id INT NOT NULL,
                         category_id INT NOT NULL,
                         status ENUM('draft', 'pending', 'published', 'rejected') DEFAULT 'draft',
                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         FOREIGN KEY (instructor_id) REFERENCES Users(id) ON DELETE CASCADE,
                         FOREIGN KEY (category_id) REFERENCES Categories(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Enrollments table (student enrollments in courses)
CREATE TABLE Enrollments (
                             id INT AUTO_INCREMENT PRIMARY KEY,
                             user_id INT NOT NULL,
                             course_id INT NOT NULL,
                             enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                             FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
                             FOREIGN KEY (course_id) REFERENCES Courses(id) ON DELETE CASCADE,
                             UNIQUE KEY unique_enrollment (user_id, course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Reviews table (student reviews for courses)
CREATE TABLE Reviews (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         user_id INT NOT NULL,
                         course_id INT NOT NULL,
                         comment TEXT NOT NULL,
                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                         FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE,
                         FOREIGN KEY (course_id) REFERENCES Courses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create indexes for better performance
CREATE INDEX idx_user_role ON Users(role);
CREATE INDEX idx_course_status ON Courses(status);
CREATE INDEX idx_course_instructor ON Courses(instructor_id);
CREATE INDEX idx_review_course ON Reviews(course_id);
CREATE INDEX idx_enrollment_user ON Enrollments(user_id);

-- Insert sample data
INSERT INTO Categories (name) VALUES
                                  ('Programming'),
                                  ('Design'),
                                  ('Business'),
                                  ('Marketing');

-- Insert sample instructor (password: instructor123)
INSERT INTO Users (name, email, password, role) VALUES
    ('Instructor One', 'instructor@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor');

-- Insert sample student (password: student123)
INSERT INTO Users (name, email, password, role) VALUES
    ('Student One', 'student@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student');