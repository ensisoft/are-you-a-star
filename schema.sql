
/* this script expects that a database has already been created */

use `ensisoftcom`;

CREATE TABLE `stars` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `visitor`    VARCHAR(255),
    `repository` VARCHAR(255),
    `date`       TIMESTAMP DEFAULT NOW(),
    PRIMARY KEY (`id`)
    );

ALTER TABLE stars ADD CONSTRAINT UNIQUE cRepo(repository);