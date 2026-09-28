-- PhotoFolio Database Schema
CREATE DATABASE IF NOT EXISTS photofolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE photofolio_db;

-- Categories for gallery filtering
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE
);

-- Gallery items / portfolio projects
CREATE TABLE IF NOT EXISTS gallery_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    client VARCHAR(255) DEFAULT NULL,
    project_date DATE DEFAULT NULL,
    project_url VARCHAR(255) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Services offered
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(100) DEFAULT 'bi-activity'
);

-- Pricing packages
CREATE TABLE IF NOT EXISTS pricing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

-- Client Testimonials
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    designation VARCHAR(255) NOT NULL,
    quote TEXT NOT NULL,
    image_url VARCHAR(255) DEFAULT 'assets/img/testimonials/testimonials-1.jpg',
    rating INT DEFAULT 5
);

-- Messages submitted from contact form
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Initial Data
INSERT INTO categories (name, slug) VALUES 
('Nature', 'nature'), 
('People', 'people'), 
('Architecture', 'architecture'), 
('Animals', 'animals'), 
('Sports', 'sports'), 
('Travel', 'travel');

INSERT INTO services (title, description, icon) VALUES
('Portrait Sessions', 'Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi', 'bi-activity'),
('Studio Lighting', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore', 'bi-bounding-box-circles'),
('Event Coverage', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia', 'bi-calendar4-week'),
('Commercial Shoots', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis', 'bi-broadcast');

INSERT INTO pricing (title, price) VALUES
('Portrait Photography', 160.00),
('Fashion Photography', 300.00),
('Sports Photography', 200.00),
('Still Life Photography', 120.00),
('Wedding Photography', 500.00),
('Photojournalism', 200.00);

INSERT INTO testimonials (name, designation, quote, image_url, rating) VALUES
('Saul Goodman', 'Ceo & Founder', 'Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.', 'assets/img/testimonials/testimonials-1.jpg', 5),
('Sara Wilsson', 'Designer', 'Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.', 'assets/img/testimonials/testimonials-2.jpg', 5),
('Jena Karlis', 'Store Owner', 'Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.', 'assets/img/testimonials/testimonials-3.jpg', 5),
('Matt Brandon', 'Freelancer', 'Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.', 'assets/img/testimonials/testimonials-4.jpg', 5),
('John Larson', 'Entrepreneur', 'Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.', 'assets/img/testimonials/testimonials-5.jpg', 5);

INSERT INTO gallery_items (category_id, title, image_url, client, project_date, project_url, description) VALUES
(1, 'Nature Morning', 'assets/img/gallery/gallery-1.jpg', 'Nature Mag', '2025-01-10', 'https://example.com', 'Morning landscape captured during sunrise with natural diffusion.'),
(2, 'Urban Portrait', 'assets/img/gallery/gallery-2.jpg', 'Studio X', '2025-02-14', 'https://example.com', 'A high-contrast street portrait taken downtown under golden hour lights.'),
(3, 'Modern Architecture', 'assets/img/gallery/gallery-3.jpg', 'Skyline Designs', '2025-03-01', 'https://example.com', 'Geometrical minimalist architecture study of modern skyscrapers.'),
(4, 'Wildlife in Motion', 'assets/img/gallery/gallery-4.jpg', 'Wild Earth', '2025-03-20', 'https://example.com', 'Action shot focusing on dynamic movement and natural lighting.'),
(5, 'Action Sports', 'assets/img/gallery/gallery-5.jpg', 'Athletics Weekly', '2025-04-05', 'https://example.com', 'Fast shutter speed freezing intense action on the track.'),
(6, 'Travel Horizons', 'assets/img/gallery/gallery-6.jpg', 'Wanderlust', '2025-05-12', 'https://example.com', 'Vibrant travel capture of authentic regional aesthetics.');
