# Liberty MediaWiki Skin

Default skin of [LibreWiki](https://librewiki.net). This skin will be the main skin for the Liberty Wiki Engine.

## Development

Our canonical source is [GitLab.com](https://gitlab.com/librewiki/Liberty-MW-Skin), and we receive bug reports via [GitLab.com](https://gitlab.com/librewiki/Liberty-MW-Skin/-/issues) and patches via GitLab.com only. Any source code found elsewhere is mirrored there, and developers do not guarantee about the code found elsewhere to work.

Security vulnerability should be reported using email (dev (골뱅이!) librewiki.net) (replace (Korean text) with @).

## Installation
* Unzip to the MediaWiki Skins folder or perform a git clone. The name of the unzipped folder should be `Liberty`.
* Add `wfLoadSkin( 'Liberty' );` to your LocalSettings.php file.

## Configurations
Please set these variables in the LocalSettings.php file.

| Name | Description | Example Variable | Default Variable |
| ---- | ---- | ---- | ---- |
| `$wgLibertyMainColor` | `theme-color` configurations, main color of site | `#4188F1` | `#4188F1` |
| `$wgLibertySecondColor` | Configure of second color of site | `#2774DC` | The value of `$wgLibertyMainColor` subtracted by `1A1415` |
| `$wgTwitterAccount` | Default Twitter account to set a mention | `librewiki` | (none) |
| `$wgLibertyOgLogo` | OpenGraph Image Logo | `https://librewiki.net/images/6/6a/Libre_favicon.png` | (Value of `$wgLogo`) |
| `$wgNaverVerification` | Naver Webmater Tool Verification Code | (Value supplied by Naver.com) | (none) |
| `$wgLibertyAdSetting` | Google Adsense Settings | `array( 'client' => '(Value supplied by Google)', 'header' => '1234567890', 'right' => '0987654321', 'belowarticle' => 1313135452 )` | (none) |
| `$wgLibertyAdGroupwgLibertyAdGroup` | Differentiation of ads by usergroup | `differ` | `null`|
| `$wgLibertyMobileReplaceAd` | In a mobile environment, move the sidebar ads to the bottom. | `true` | `false` |
| `$wgLibertyEnableLiveRC` | Enables 'Recent Cahnges' on the right side | `true` | `true` |
| `$wgLibertyMaxRecent` | Recent X edits appearing in 'Recent Changes' | `10` | `10` |
| `$wgLibertyLiveRCArticleNamespaces` | Namespaces for the first tab in 'Recent Changes' | `[NS_MAIN, NS_PROJECT, NS_TEMPLATE, NS_HELP, NS_CATEGORY]` | `[NS_MAIN, NS_PROJECT, NS_TEMPLATE, NS_HELP, NS_CATEGORY]` |
| `$wgLibertyLiveRCTalkNamespaces` | Namespaces for the second tab in 'Recent Changes' | `[NS_TALK, NS_USER_TALK, NS_PROJECT_TALK, NS_FILE_TALK, NS_MEDIAWIKI_TALK, NS_TEMPLATE_TALK, NS_HELP_TALK, NS_CATEGORY_TALK]` | `[NS_TALK, NS_USER_TALK, NS_PROJECT_TALK, NS_FILE_TALK, NS_MEDIAWIKI_TALK, NS_TEMPLATE_TALK, NS_HELP_TALK, NS_CATEGORY_TALK]` |

## Navbar
Please fill out `MediaWiki:Liberty-Navbar` article in the following format.

* First-Level menu:
  * `* icon=icon | display=display text | title=hover text | link=link | access=shortcut key | class=custom HTML classes | group=required user group | right=required user right`
* Second-Level menu:
  * `** icon=icon | display=display text | title=hover text | link=link | access=shortcut key | class=custom HTML classes | group=required user group | right=required user right`
* Third-Level menu:
  * `*** icon=icon | display=display text | title=hover text | link=link | access=shortcut key | class=custom HTML classes | group=required user group | right=required user right`
---
* All values are optional, but at least one of `icon` or `display` must be set.
* If `title` is not set, `display` is used instead.
* If you don't want to set some parameters, you can skip them. As an example, if you don't want to set an icon, skip `icon=...`.
* You can use i18n message names of MediaWiki for the values of `display` and `title` to show the i18n messages (e.g., write `recentchanges` to show `Recent changes`).
* Shortcut keys can be used as `Alt-Shift-(Key)`.
* When setting shortcuts, be careful not to overlap with the default shortcuts provided by MediaWiki.
* Custom classes are separated by `,` (e.g., write `classA, classB` to add `classA` and `classB` class).

You can see an example on [LibreWiki](https://librewiki.net/wiki/MediaWiki:Liberty-Navbar).

## Rights
Four rights have been added to this to implement ad differentiation by user rights. if $wgLibertyAdGroup is set to 'differ', add user preferences to remove ads.
* blockads-header : User can remove header ads.
* blockads-right : User can remove header ads.
* blockads-belowarticle : User can remove ads below article.
* blockads-bottom : User can remove bottom ads.