# Liberty MediaWiki Engine

[한국어](README.md)

Default skin of [Libre Wiki](https://librewiki.net). This skin will be the main skin for the Liberty Wiki Framework.

## Development

Our canonical source is [GitLab.com](https://gitlab.com/librewiki/Liberty-MW-Skin), and we receive bug reports via [LibreWiki Phabricator](https://issue.librewiki.net). Any source code found elsewhere is mirrored there, and developers do not guarantee about the code found elsewhere to work.

## Configurations

| Name | Description | Example Variable | Default Variable | 
| ---- | ---- | ---- | ---- |
| `$wgLibertyMainColor` | `theme-color` configurations | `#4188F1` | `#4188F1` |
| `$wgTwitterAccount` | Default Twitter account to set a mention | `librewiki` | (none) | 
| `$wgLibertyOGLogo` | OpenGraph Image Logo | `https://librewiki.net/images/6/6a/Libre_favicon.png` | (Value of `$wgLogo`) |
| `$wgNaverVerification` | Naver Webmater Tool Verification Code | (Value supplied by Naver.com) | (none) |
| `$wgLibertyAdSetting` | Google Adsense Settings | `array( "client" => "(Value supplied by Google)", "header" => "3627980722", "right" => "6581447128" )` | (none) |
| `$wgLibertyMaxRecent` | Recent X edits appearing in "Recent Changes" bar in the skin | `10` | `10` |

## NavVar

Edit `MediaWiki:Liberty-NavVar` page to modify the value. Example is on [LibreWiki](https://librewiki.net/wiki/MediaWiki:Liberty-Navbar).