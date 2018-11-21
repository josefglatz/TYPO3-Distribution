CREATE TABLE tt_content (
	tx_theme_bodytext_1 text,
	tx_theme_bodytext_2 text,

	tx_theme_big_media int(11) unsigned DEFAULT '0',
	tx_theme_unfolded int(11) unsigned DEFAULT '0',
	tx_theme_prefer_download int(11) unsigned DEFAULT '0',
	tx_theme_link varchar(1024) DEFAULT '' NOT NULL,
	tx_theme_link_label tinytext,
	tx_theme_author tinytext,
	tx_theme_facts_figures int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE pages (
	tx_theme_hide_page_heading tinyint(4) unsigned DEFAULT '0' NOT NULL,
	tx_theme_link_label tinytext,
	tx_theme_nav_image int(11) unsigned DEFAULT '0' NOT NULL,
	tx_theme_related int(11) DEFAULT '0' NOT NULL,
	tx_theme_sharing_enabled tinyint(4) unsigned DEFAULT '1' NOT NULL,
	tx_theme_show_in_secondary_navigation tinyint(4) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE sys_file_reference (
	tx_theme_video_autoplay tinyint(1) unsigned DEFAULT '0' NOT NULL,
	tx_theme_video_showinfo tinyint(1) unsigned DEFAULT '0' NOT NULL,
	tx_theme_video_rel tinyint(1) unsigned DEFAULT '0' NOT NULL,
	tx_theme_video_startminute int(11) DEFAULT '0' NOT NULL,
	tx_theme_video_startsecond int(11) DEFAULT '0' NOT NULL,
	tx_theme_video_ratio tinyint(1) unsigned DEFAULT '0' NOT NULL,
	tx_theme_video_fullscreen tinyint(1) unsigned DEFAULT '0' NOT NULL,
	tx_theme_video_loop tinyint(1) unsigned DEFAULT '0' NOT NULL,
	tx_theme_video_covertitle tinytext,
	tx_theme_video_covertext tinytext,
	tx_theme_video_coverimage int(11) unsigned DEFAULT '0' NOT NULL,
	tx_theme_youtube_color tinytext
);

CREATE TABLE tx_theme_related_pages_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);


CREATE TABLE tx_theme_facts_figures (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	parentid int(11) DEFAULT '0' NOT NULL,
	parenttable varchar(255) DEFAULT '' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	t3ver_oid int(11) unsigned DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) unsigned DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	label tinytext,
	value tinytext,
	icon int(11) unsigned DEFAULT '0' NOT NULL,
	link tinytext,
	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);
