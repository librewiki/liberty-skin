--
-- Table structure for table `liberty_usersettings`
--

CREATE TABLE /*_*/liberty_usersettings(
  user int NOT NULL,
  colorMain text(18) DEFAULT NULL,
  colorSub text(18) DEFAULT NULL,
  colorAutoSub boolean DEFAULT true,
  sidebarPosition int(2) DEFAULT 2,
  sidebarContent int(2) DEFAULT 3,
  navbarHideName boolean DEFAULT false,
  navbarFastOut boolean DEFAULT false
)/*$wgDBTableOptions*/;