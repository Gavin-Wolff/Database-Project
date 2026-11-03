
-- =====================================
-- SMARTBASE MOCK DATA
-- =====================================

-- 1. LOCATIONS
INSERT INTO location
(LocationID, City, State, County, Latitude, Longitude, Timezone)
VALUES
(1, 'Moscow', 'Idaho', 'Latah', 46.7324, -117.0002, 'America/Los_Angeles'),
(2, 'Pullman', 'Washington', 'Whitman', 46.7298, -117.1817, 'America/Los_Angeles'),
(3, 'Lewiston', 'Idaho', 'Nez Perce', 46.4004, -117.0012, 'America/Los_Angeles');


-- 2. STORES
INSERT INTO store
(StoreID, LocationID, Name, Type, PriceRating, HoursOfOperation, CustomerReviews)
VALUES
(1, 1, 'Moscow Market', 'Grocery', 2, '8 AM - 9 PM', 4.20),
(2, 1, 'Moscow Fresh', 'Grocery', 1, '7 AM - 10 PM', 4.50),
(3, 2, 'Pullman Market', 'Grocery', 2, '8 AM - 9 PM', 4.10),
(4, 2, 'Pullman Foods', 'Grocery', 3, '7 AM - 10 PM', 4.30),
(5, 3, 'Lewiston Market', 'Grocery', 2, '8 AM - 9 PM', 4.00),
(6, 3, 'Lewiston Fresh', 'Grocery', 1, '7 AM - 10 PM', 4.40);


-- 3. CATEGORIES
INSERT INTO item
(ItemID, ParentItemID, ItemName, Description, ItemType)
VALUES
(1, NULL, 'Dairy', 'Milk, cheese, and dairy products', 'Category'),
(2, NULL, 'Produce', 'Fresh fruits and vegetables', 'Category');


-- 4. PRODUCTS
INSERT INTO item
(ItemID, ParentItemID, ItemName, Description, ItemType)
VALUES
(3, 1, 'Milk', 'One gallon of whole milk', 'Product'),
(4, 1, 'Cheese', 'One package of cheddar cheese', 'Product'),
(5, 1, 'Eggs', 'One dozen large eggs', 'Product'),
(6, 1, 'Butter', 'One pound of butter', 'Product'),
(7, 2, 'Apples', 'One pound of fresh apples', 'Product'),
(8, 2, 'Bananas', 'One pound of bananas', 'Product'),
(9, 2, 'Potatoes', 'One pound of potatoes', 'Product'),
(10, 2, 'Tomatoes', 'One pound of fresh tomatoes', 'Product');


-- 5. STORE ITEMS / PRICES
INSERT INTO storeitem
(StoreID, ItemID, Price, StockStatus, ProductRating)
VALUES
-- Milk
(1, 3, 3.49, 'In Stock', 4.5),
(2, 3, 2.99, 'In Stock', 4.4),
(3, 3, 3.79, 'In Stock', 4.3),
(4, 3, 3.29, 'Limited', 4.2),
(5, 3, 3.59, 'In Stock', 4.4),
(6, 3, 2.89, 'In Stock', 4.6),

-- Cheese
(1, 4, 4.99, 'In Stock', 4.5),
(2, 4, 4.49, 'In Stock', 4.3),
(3, 4, 5.29, 'In Stock', 4.2),
(5, 4, 4.79, 'Limited', 4.4),

-- Eggs
(1, 5, 3.99, 'In Stock', 4.6),
(2, 5, 3.49, 'In Stock', 4.5),
(3, 5, 4.29, 'In Stock', 4.3),
(4, 5, 3.79, 'In Stock', 4.4),
(6, 5, 3.39, 'In Stock', 4.7),

-- Butter
(1, 6, 4.29, 'In Stock', 4.4),
(2, 6, 3.99, 'In Stock', 4.5),
(4, 6, 4.59, 'Limited', 4.2),

-- Apples
(1, 7, 1.99, 'In Stock', 4.5),
(2, 7, 1.79, 'In Stock', 4.4),
(3, 7, 2.29, 'In Stock', 4.3),
(5, 7, 1.89, 'In Stock', 4.6),

-- Bananas
(1, 8, 0.69, 'In Stock', 4.6),
(2, 8, 0.59, 'In Stock', 4.5),
(3, 8, 0.79, 'In Stock', 4.4),
(6, 8, 0.55, 'In Stock', 4.7),

-- Potatoes
(1, 9, 1.49, 'In Stock', 4.3),
(2, 9, 1.29, 'In Stock', 4.4),
(4, 9, 1.59, 'In Stock', 4.2),
(5, 9, 1.39, 'In Stock', 4.5),

-- Tomatoes
(1, 10, 2.49, 'In Stock', 4.4),
(2, 10, 2.19, 'In Stock', 4.5),
(3, 10, 2.79, 'Limited', 4.3),
(6, 10, 2.29, 'In Stock', 4.6);
