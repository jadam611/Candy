create table IF NOT EXISTS products
(
    product_id     INTEGER not null
    primary key autoincrement,
    ProductName      TEXT,
    Category  TEXT,
    Price     INTEGER,
    Image  REAL,
    Quantity  TEXT,
    Code      VARCHAR(100)
);