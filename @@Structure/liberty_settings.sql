--
-- Table structure for table `liberty_settings`
--

CREATE TABLE /*_*/liberty_settings(
  date int(10) NOT NULL,
  modifier int NOT NULL,
  colorMain text(18) DEFAULT NULL,
  colorSUb text(18) DEFAULT NULL,
  colorAutoSub boolean DEFAULT true,
  sidebarPosition int(2) DEFAULT 2,
  sidebarContent int(2) DEFAULT 3,
  navbarLogo text DEFAULT NULL,
  navbarHideGeneral int(3), 0,
  navbarHideName boolean DEFAULT false,
  navbarFastOut boolean DEFAULT false,
  navbarHideLogin boolean DEFAULT false,
  loginUseModel boolean DEFAULT true,
  editToolsHide int(3) DEFAULT 3,
  metaOpenGraphLogo text DEFAULT NULL
)/*$wgDBTableOptions*/;