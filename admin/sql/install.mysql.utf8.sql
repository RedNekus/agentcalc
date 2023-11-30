DROP TABLE IF EXISTS `#__agentcalc_settings`;

CREATE TABLE IF NOT EXISTS `#__agentcalc_settings` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `term` tinyint(4) unsigned NOT NULL,
    `remuneration` tinyint(4) unsigned NOT NULL,
    PRIMARY KEY (`id`)
)
    ENGINE=InnoDB
    DEFAULT CHARSET=utf8mb4
    DEFAULT COLLATE=utf8mb4_unicode_ci
    AUTO_INCREMENT=0;