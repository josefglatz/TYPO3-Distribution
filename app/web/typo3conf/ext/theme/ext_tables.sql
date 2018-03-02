CREATE TABLE tt_content (
	bodytext_1 text,
	bodytext_2 text
);

CREATE TABLE pages (
	tx_theme_hide_page_heading tinyint(4) unsigned DEFAULT '0' NOT NULL,
	tx_theme_robot_index tinyint(4) unsigned DEFAULT '1' NOT NULL,
	tx_theme_robot_follow tinyint(4) unsigned DEFAULT '1' NOT NULL,
	tx_theme_sharing_enabled tinyint(4) unsigned DEFAULT '1' NOT NULL,
	tx_theme_opengraph_image int(11) unsigned DEFAULT '0' NOT NULL
);
