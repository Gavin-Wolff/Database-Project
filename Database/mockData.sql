
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
(6, 3, 'Lewiston Fresh', 'Grocery', 1, '7 AM - 10 PM', 4.40),
(7, 1, 'Moscow Walmart', 'Department', 1, '6 AM - 11 PM', 4.0),
(8, 1, 'Moscow WinCo Foods', 'Grocery', 1, 'Open 24 Hours', 4.5),
(9, 1, 'Moscow SafeWay', 'Grocery', 3, '6 AM - 12 AM', 4.2),
(10, 1, 'Moscow Target', 'Department', 2, '7 AM - 10 PM', 4.0),
(11, 2, 'Pullman Walmart', 'Department', 1, '6 AM - 11 PM', 4.0),
(12, 1, 'Home Depot', 'Hardware', 3, '6 AM - 9 PM', 3.8);

-- 3. CATEGORIES
INSERT INTO item
(ItemID, ParentItemID, ItemName, Description, ItemType)
VALUES
(1, NULL, 'Dairy', 'Milk, cheese, and dairy products', 'Category'),
(2, NULL, 'Produce', 'Fresh fruits and vegetables', 'Category'),
(11, NULL, 'Clothing', 'Clothes', 'Category'),
(12, NULL, 'Personal Care', 'Personal care items', 'Category'),
(13, 1, 'Milk', 'Milk products', 'Category'),
(14, 4, 'Hair Care', 'Hair care items', 'Category'),
(15, NULL, 'Hardware', 'Hardware and supplies', 'Category'),
(16, NULL, 'Vehicle', 'Vehicle components', 'Category');



-- 4. PRODUCTS
INSERT INTO item
(ItemID, ParentItemID, ItemName, Description, ItemType)
VALUES
(3, 13, 'Milk', 'One gallon of whole milk', 'Product'),
(4, 1, 'Cheese', 'One package of cheddar cheese', 'Product'),
(5, 1, 'Eggs', 'One dozen large eggs', 'Product'),
(6, 1, 'Butter', 'One pound of butter', 'Product'),
(7, 2, 'Apples', 'One pound of fresh apples', 'Product'),
(8, 2, 'Bananas', 'One pound of bananas', 'Product'),
(9, 2, 'Potatoes', 'One pound of potatoes', 'Product'),
(10, 2, 'Tomatoes', 'One pound of fresh tomatoes', 'Product'),
(17, 13, 'Almond Milk', 'Half a gallon of almond milk', 'Product'),
(18, 13, 'Oat Milk', 'Half a gallon of oat milk', 'Product'),
(19, 13, 'Coconut Milk', 'Half a gallon of coconut milk', 'Product'),
(20, 11, 'Sweater', 'A winter sweater', 'Product'),
(21, 11, 'Sweatpants', 'A pair of sweatpants', 'Product'),
(22, 14, 'Shampoo', 'A bottle of shampoo', 'Product'),
(23, 14, 'Conditioner', 'A bottle of conditioner', 'Product'),
(24, 11, 'Gloves', 'A pair of winter gloves', 'Product');


-- 5. STORE ITEMS / PRICES
INSERT INTO storeitem
(StoreID, ItemID, Price, StockStatus, ProductRating)
VALUES
-- Milk
(1, 3, 3.49, 'In Stock', 4.5),
(1, 17, 5.49, 'In Stock', 3.9),
(1, 18, 4.55, 'In Stock', 3.6),
(1, 19, 4.65, 'In Stock', 3.1),
(2, 3, 2.99, 'In Stock', 4.4),
(2, 17, 4.49, 'In Stock', 3.9),
(2, 18, 3.55, 'In Stock', 3.6),
(2, 19, 4.25, 'In Stock', 3.1),
(3, 3, 3.79, 'In Stock', 4.3),
(3, 17, 4.49, 'In Stock', 3.9),
(3, 18, 4.15, 'In Stock', 3.6),
(3, 19, 4.25, 'In Stock', 3.1),
(4, 3, 3.29, 'Limited', 4.2),
(4, 17, 5.29, 'In Stock', 3.9),
(4, 18, 4.15, 'In Stock', 3.6),
(4, 19, 4.35, 'In Stock', 3.1),
(5, 3, 3.59, 'In Stock', 4.4),
(5, 17, 5.69, 'In Stock', 3.9),
(5, 18, 4.85, 'In Stock', 3.6),
(5, 19, 4.95, 'In Stock', 3.1),
(6, 3, 2.89, 'In Stock', 4.6),
(6, 17, 4.69, 'In Stock', 3.9),
(6, 18, 4.05, 'In Stock', 3.6),
(6, 19, 4.15, 'In Stock', 3.1),



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
(6, 10, 2.29, 'In Stock', 4.6),

-- Shampoo
(1, 22, 8.65, 'In Stock', 4.9),
(2, 22, 9.95, 'In Stock', 4.6),
(6, 22, 8.15, 'In Stock', 4.0),
(7, 22, 12.15, 'Limited', 2.2),
(8, 22, 10.25, 'In Stock', 1.9),
(9, 22, 7.95, 'In Stock', 4.7),
(10, 22, 9.55, 'Limited', 4.1),

-- Conditioner
(11, 23, 11.65, 'In Stock', 3.4);
