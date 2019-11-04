# Liberty MediaWiki Skin

Default skin of [LibreWiki](https://librewiki.net). This skin will be the main skin for the Liberty Wiki Engine.

## Development

Our canonical source is [GitLab.com](https://gitlab.com/librewiki/Liberty-MW-Skin), and we receive bug reports via [LibreWiki Phabricator](https://issue.librewiki.net) and patches via GitLab.com only. Any source code found elsewhere is mirrored there, and developers do not guarantee about the code found elsewhere to work.

Security vulnerability should be reported using [Phabricator](https://issue.librewiki.net/maniphest/task/edit/form/7/).

## Configurations

| Name | Description | Example Variable | Default Variable |
| ---- | ---- | ---- | ---- |
| `$wgLibertyMainColor` | `theme-color` configurations, main color of site | `#4188F1` | `#4188F1` |
| `$wgLibertySecondColor` | Configure of second color of site | `#2774DC` | The value of `$wgLibertyMainColor` subtracted by `1A1415` |
| `$wgTwitterAccount` | Default Twitter account to set a mention | `librewiki` | (none) |
| `$wgLibertyOgLogo` | OpenGraph Image Logo | `https://librewiki.net/images/6/6a/Libre_favicon.png` | (Value of `$wgLogo`) |
| `$wgNaverVerification` | Naver Webmater Tool Verification Code | (Value supplied by Naver.com) | (none) |
| `$wgLibertyAdSetting` | Google Adsense Settings | `array( 'client' => '(Value supplied by Google)', 'header' => '1234567890', 'right' => '0987654321' )` | (none) |
| `$wgLibertyMaxRecent` | Recent X edits appearing in 'Recent Changes' bar in the skin | `10` | `10` |

## Navbar
Please fill out `MediaWiki:Liberty-Navbar` article in the following format.

First-Level menu : `* icon=Icon | display=Display Text | title=Hover Text | link=Link | access=Shortcut Key | class=Custom HTML Class | group=Needed user group | right=Needed user right`  
Second-Level menu : `** icon=Icon | display=Display Text | title=Hover Text | link=Link | access=Shortcut Key | class=Custom HTML Class | group=Needed user group | right=Needed user right`  
Third-Level menu : `*** icon=Icon | display=Display Text | title=Hover Text | link=Link | access=Shortcut Key | class=Custom HTML Class | group=Needed user group | right=Needed user right`
* All settings are optional, but One of `Icon` or `Text to display` must be set.
* If `Text to display when hover` is not set, It is set to `Text to display` value automatically.
* If you not want set some value, just skip that. As an example, If you not want to set icon, you can skip include `icon=`.
* When set `Text to display` or `Text to display when hover`, You can type MediaWiki i18n message name to display that i18n message value. (Example: Displays `Recent changes` when type `recentchanges`)
* Shortcut can be used by `Alt-Shift-(Key)`.
* When setting shortcut, Please be careful not to overlap the basic shortcut provided by MediaWiki.
* Set custom class separated by `,`. (Example: Type `classA, classB` to add `classA` and `classB` class)

You can see an example at [LibreWiki](https://librewiki.net/wiki/MediaWiki:Liberty-Navbar), But not that site always use latest version of this skin.
