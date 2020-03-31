-- Users
CREATE TABLE IF NOT EXISTS `users`
(
    user_id    INT AUTO_INCREMENT                   NOT NULL,
    first_name VARCHAR(36)                          NOT NULL,
    last_name  VARCHAR(36)                          NOT NULL,
    email      VARCHAR(128)                         NOT NULL UNIQUE,
    password   VARCHAR(64)                          NOT NULL,
    phone      VARCHAR(12)                                  UNIQUE,
    image      VARCHAR(64),
    bio        VARCHAR(512),
    type       ENUM ('consumer', 'seller', 'admin') NOT NULL DEFAULT 'consumer',
    PRIMARY KEY (user_id)
);

-- Items
CREATE TABLE IF NOT EXISTS `items`
(
    item_id      INT AUTO_INCREMENT NOT NULL,
    seller_id    INT                NOT NULL,
    name         VARCHAR(64)        NOT NULL UNIQUE,
    author       VARCHAR(64)        NOT NULL,
    price        REAL               NOT NULL,
    stock        INT                NOT NULL,
    image        VARCHAR(64)        NOT NULL,
    description  VARCHAR(512)       NOT NULL,
    rating_count INT                NOT NULL DEFAULT 0,
    total_rating INT                NOT NULL DEFAULT 0,
    PRIMARY KEY (item_id),
    FOREIGN KEY (seller_id) REFERENCES users (user_id) ON DELETE CASCADE
);


-- Cart Items
CREATE TABLE IF NOT EXISTS `cart_items`
(
    user_id  INT NOT NULL,
    item_id  INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    PRIMARY KEY (user_id, item_id),
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES items (item_id) ON DELETE CASCADE
);

-- Wishlist Items
CREATE TABLE IF NOT EXISTS `wishlist_items`
(
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    PRIMARY KEY (user_id, item_id),
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES items (item_id) ON DELETE CASCADE
);

-- Orders
CREATE TABLE IF NOT EXISTS `orders`
(
    order_id   INT AUTO_INCREMENT NOT NULL,
    user_id    INT                NOT NULL,
    order_time TIMESTAMP          NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (order_id),
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE NO ACTION
);

-- Sold Items
CREATE TABLE IF NOT EXISTS `sold_items`
(
    item_id  INT NOT NULL,
    order_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    PRIMARY KEY (item_id, order_id),
    FOREIGN KEY (item_id) REFERENCES items (item_id) ON DELETE NO ACTION,
    FOREIGN KEY (order_id) REFERENCES orders (order_id) ON DELETE NO ACTION
);

-- Subscription Plans
CREATE TABLE IF NOT EXISTS `subscription_plans`
(
    plan_id INT  NOT NULL AUTO_INCREMENT,
    price   REAL NOT NULL,
    credits INT  NOT NULL,
    PRIMARY KEY (plan_id)
);

-- Subscriptions
CREATE TABLE IF NOT EXISTS `subscriptions`
(
    subscription_id INT       NOT NULL AUTO_INCREMENT,
    user_id         INT       NOT NULL UNIQUE,
    plan_id         INT       NOT NULL,
    start_date      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (subscription_id),
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE,
    FOREIGN KEY (plan_id) REFERENCES subscription_plans (plan_id) ON DELETE RESTRICT
);

-- Seller Requests
CREATE TABLE IF NOT EXISTS `seller_requests`
(
    request_id   INT       NOT NULL AUTO_INCREMENT,
    user_id      INT       NOT NULL,
    request_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (request_id),
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE CASCADE
);

-- Reviews
CREATE TABLE IF NOT EXISTS `seller_reviews`
(
    user_id   INT NOT NULL,
    seller_id INT NOT NULL,
    value     INT NOT NULL,
    comment   VARCHAR(250),
    PRIMARY KEY (user_id, seller_id),
    FOREIGN KEY (user_id) REFERENCES users (user_id) ON DELETE NO ACTION,
    FOREIGN KEY (seller_id) REFERENCES users (user_id) ON DELETE CASCADE
);

-- Shipping
CREATE TABLE IF NOT EXISTS `shipping_information`
(
    order_id         INT          NOT NULL,
    shipping_address VARCHAR(255) NOT NULL,
    PRIMARY KEY (order_id),
    FOREIGN KEY (order_id) REFERENCES orders (order_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `recommendations`
(
    recommendation_id INT AUTO_INCREMENT NOT NULL,
    item_id           INT                NOT NULL,
    PRIMARY KEY (recommendation_id),
    FOREIGN KEY (item_id) REFERENCES items (item_id)
);