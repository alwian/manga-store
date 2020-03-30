-- Users
CREATE TABLE IF NOT EXISTS `users`
(
    user_id    INT AUTO_INCREMENT                   NOT NULL,
    first_name VARCHAR(36)                          NOT NULL,
    last_name  VARCHAR(36)                          NOT NULL,
    email      VARCHAR(128)                         NOT NULL UNIQUE,
    password   VARCHAR(64)                          NOT NULL,
    phone      VARCHAR(12) UNIQUE,
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
    price        REAL               NOT NULL,
    stock        INT                NOT NULL,
    image        VARCHAR(64)        NOT NULL,
    description  VARCHAR(512)       NOT NULL,
    rating_count INT                NOT NULL DEFAULT 0,
    total_rating INT                NOT NULL DEFAULT 0,
    PRIMARY KEY (item_id),
    FOREIGN KEY (seller_id) REFERENCES users (user_id) ON DELETE CASCADE
);

-- Genres
CREATE TABLE IF NOT EXISTS `genres`
(
    item_id INT         NOT NULL,
    genre   VARCHAR(20) NOT NULL,
    PRIMARY KEY (item_id, genre),
    FOREIGN KEY (item_id) REFERENCES items (item_id) ON DELETE CASCADE
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
)

--
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
  `title` varchar(50) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recommendations`
--

INSERT INTO `recommendations` (`title`, `link`, `image`) VALUES
('Berserk', '4e70ea0ec092255ef7004a28', 'a0/a0d72bd4356ce4e06d5d3287816fdee0dc8fe5b23cd4cdaf9ecd5962.jpg'),
('Naruto', '4e70ea03c092255ef70046f0', 'd1/d1cd664cefc4d19ec99603983d4e0b934e8bce91c3fccda3914ac029.png'),
('Boruto:Naruto Next Generations', '5754a49e719a1641fd988b6d', 'a6/a6cb9ecfe372e142bf15a33aaa7bd37fcf907ec5a01c3ccd230ad53b.jpg'),
('Bleach', '4e70e9efc092255ef7004274', '99/99af14772b89d87e6f3deb7d6b174537908a3fc5e7cc7eb6fbf92a68.jpg'),
('Attack On Titan', '4e70ea6ac092255ef7006a52', 'e4/e4258fe3f23f923de39ae56d82449226cd2b6be40279e9acb7f8138e.png'),
('Boku No Hero Academia', '541aabc045b9ef49009d69b6', '22/22ad82d99042582b10c7293114cd199de406a5b662454553eff5015a.png'),
('One Piece', '4e70ea10c092255ef7004aa2', 'b0/b0ac7f12d2cb0fc07b9418d5544a3f97cbbc30e967396ae70f98d101.png'),
('Fireforce', '5be0cf44719a161d84b9f0e4', 'd6/d65fd1ca956b3491e0108a1d4ce4d840b5dcd4eccf9c3f691b9c76d9.jpg'),
('Assasination Classroom', '4ff30370c092252e7f00002f', 'ec/ec4c870e4b6f25cf69e7a7ea764065d7232ac83972116f7a0572282e.png'),
('Vinland Saga', '4e70ea03c092255ef700470e', '49/4992cf81b0f3ce055a1be9f128ff8d0f015dd5cd58aa3c448070c6ae.png'),
('Vagabond', '4e70ea04c092255ef700475e', '99/9982ab1bab822353edb04f3b6ebd8b70499d8195634c0c606733ce27.jpg'),
('Uzumaki', '4e70e9ddc092255ef7003d01', '67/67a0c7878afa36e8b9a4e1e22c1141310310b1de54f55a03b21fde26.png'),
('Gyo', '4e70ea23c092255ef7004f1f', '40/40c35bb99851a54a973a8168c500c13e02c459358117d7b58c57d528.png'),
('Jojo Bizzare Adventure', '4e70ea06c092255ef70047d1', '02/026230ba1e2abacb1d2374de788d581d0067a8f279536a856c1eb625.png'),
('Hunter X Hunter', '4e70ea02c092255ef70046e0', 'df/dfa10afb26c40498e742a80653d23aa0d5ce96cd9c6b6e3f65d09507.jpg');