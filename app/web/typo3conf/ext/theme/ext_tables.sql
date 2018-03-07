CREATE TABLE tt_content (
	bodytext_1 text,
	bodytext_2 text
);

CREATE TABLE pages (
	tx_theme_hide_page_heading tinyint(4) unsigned DEFAULT '0' NOT NULL,
	tx_theme_link_label tinytext,
	tx_theme_nav_image int(11) unsigned DEFAULT '0' NOT NULL,
	tx_theme_opengraph_description varchar(255) DEFAULT '' NOT NULL,
	tx_theme_opengraph_image int(11) unsigned DEFAULT '0' NOT NULL,
	tx_theme_opengraph_title varchar(255) DEFAULT '' NOT NULL,
	tx_theme_related int(11) DEFAULT '0' NOT NULL,
	tx_theme_robot_follow tinyint(4) unsigned DEFAULT '1' NOT NULL,
	tx_theme_robot_index tinyint(4) unsigned DEFAULT '1' NOT NULL,
	tx_theme_sharing_enabled tinyint(4) unsigned DEFAULT '1' NOT NULL,
	tx_theme_show_in_secondary_navigation tinyint(4) unsigned DEFAULT '0' NOT NULL,
	tx_theme_twitter_description varchar(255) DEFAULT '' NOT NULL,
	tx_theme_twitter_image int(11) unsigned DEFAULT '0' NOT NULL,
	tx_theme_twitter_title varchar(255) DEFAULT '' NOT NULL
);

CREATE TABLE tx_theme_related_pages_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);
