-- Usuwanie tabel, jeśli istnieją
DROP TABLE IF EXISTS product_images;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS categories;

-- Tworzenie tabeli categories
CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    parent_id INT UNSIGNED NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    image_path VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_categories_parent
        FOREIGN KEY (parent_id) REFERENCES categories(id)
        ON DELETE SET NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tworzenie tabeli products
CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category_id INT UNSIGNED NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    description TEXT NULL,
    properties JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_products_category
        FOREIGN KEY (category_id) REFERENCES categories(id)
        ON DELETE SET NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tworzenie tabeli product_images
CREATE TABLE product_images (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    path VARCHAR(255) NOT NULL,
    alt VARCHAR(255) NULL,
    is_main TINYINT(1) DEFAULT 0,
    sort_order INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_product_images_product
        FOREIGN KEY (product_id) REFERENCES products(id)
        ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tworzenie tabeli admins
CREATE TABLE admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    hashed_password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Tworzenie indeksów
CREATE INDEX idx_products_category_id ON products (category_id);
CREATE INDEX idx_product_images_product_id ON product_images (product_id);

-- Wstawianie danych do kategorii
INSERT INTO categories (id, parent_id, name, slug, description, image_path)
VALUES
(1, NULL, 'Chemia budowlana', 'chemia-budowlana', 'Kleje, piany, silikony...', 'img/categories/chemia-budowlana.webp'),
(2, 1, 'Kleje i piany', 'kleje-i-piany', 'Kleje montażowe, piany PU...', 'img/categories/kleje-i-piany.webp'),
(3, 2, 'Kleje do styropianu', 'kleje-do-styropianu', 'Kleje EPS/XPS...', 'img/categories/kleje-do-styropianu.webp');

-- Wstawianie danych do produktów
INSERT INTO products (name, category_id, price, description, properties)
VALUES 
('Klej do styropianu Atlas', 3, 29.99, 'Profesjonalny klej do styropianu EPS.', NULL),  -- Zmieniamy properties na NULL, bo nie ma tego w danym przypadku
('Młotek murarski 500g', 1, 39.99, 'Solidny młotek murarski o wadze 500g, idealny do prac budowlanych.', JSON_OBJECT('waga', '500g', 'material', 'stal + drewno'));
-- Wstawianie danych do obrazków produktów
INSERT INTO product_images (product_id, path, alt, is_main, sort_order)
VALUES 
(1, 'uploads/products/2026/03/mlotek.webp', 'Młotek murarski 500g', 1, 0);