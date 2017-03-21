--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` char(20) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `pid` int(11) unsigned NOT NULL DEFAULT 0,
  `name` char(20) NOT NULL DEFAULT '',
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_up` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '上次修改用户时间',
  `salt` char(6) NOT NULL DEFAULT '' COMMENT '盐,保护用户密码安全',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `captchas`
--

CREATE TABLE IF NOT EXISTS `captchas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号码',
  `captcha` varchar(10) NOT NULL DEFAULT '' COMMENT '验证码',
  `expires_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '验证码有效期',
  `status` tinyint(4) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=MyISAM  AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;