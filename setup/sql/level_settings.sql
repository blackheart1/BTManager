INSERT INTO `#prefix#_level_settings` (`group_id`, `group_type`, `group_default`, `group_founder_manage`, `group_name`, `group_desc`, `group_desc_bitfield`, `group_desc_options`, `group_desc_uid`, `group_display`, `group_avatar`, `group_avatar_type`, `group_avatar_width`, `group_avatar_height`, `group_rank`, `group_colour`, `group_sig_chars`, `group_receive_pm`, `group_message_limit`, `group_max_recipients`, `group_legend`, `group_skip_auth`) VALUES
(1, 3, 0, 1, 'ADMINISTRATORS', 'High level staff - will help with any problems', '', 7, '', 0, '', 0, 0, 0, 1, '7FFF00', 0, 0, 0, 0, 1, 0),
(2, 3, 0, 0, 'MODERATOR', '', '', 7, '', 0, '', 0, 0, 0, 0, 'B0E2FF', 0, 0, 0, 0, 1, 0),
(3, 3, 0, 0, 'PREMIUM_USER', '', '', 7, '', 0, '', 0, 0, 0, 0, 'D4A017', 0, 0, 0, 0, 1, 0),
(4, 3, 1, 0, 'USER', '', '', 7, '', 0, '', 0, 0, 0, 4, 'FF0000', 0, 0, 0, 0, 1, 0),
(5, 0, 0, 1, 'Owner', '', '', 7, '', 0, '', 0, 0, 0, 0, 'FFFF00', 0, 0, 0, 0, 1, 0),
(7, 0, 0, 0, 'Power User', '', '', 7, '', 0, '', 0, 0, 0, 0, 'EE9A00', 0, 0, 0, 0, 1, 0),
(8, 0, 0, 0, 'S.F.B.', '', '', 7, '', 0, '', 0, 0, 0, 0, 'CDAA7D', 0, 0, 0, 0, 1, 0),
(9, 0, 0, 0, 'Super-Uploader', '', '', 7, '', 0, '', 0, 0, 0, 0, 'FF6347', 0, 0, 0, 0, 1, 0),
(10, 0, 0, 0, 'Uploader', 'This is a group of people that upload what they can mosly from their own PC', '', 7, '', 0, '', 0, 0, 0, 0, '20B2AA', 0, 0, 0, 0, 1, 0),
(6, 2, 0, 0, 'Guest', 'Default group for not logged in users', '', 7, '', 0, '', 0, 0, 0, 4, 'FF9999', 0, 0, 0, 0, 0, 0);