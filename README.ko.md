# Liberty MediaWiki Skin

[리브레 위키](https://librewiki.net)의 기본 스킨입니다. 위키 엔진 '리버티'의 기본 레이아웃이 될 예정입니다.

## 개발

원본 소스는 [GitLab.com](https://gitlab.com/librewiki/Liberty-MW-Skin)에 존재하며, 버그 리포팅은 [Phabricator](https://issue.librewiki.net/)에서, 패치는 GitLab.com 에서만 받고 있습니다. 이 외의 호스팅에서 발견되는 코드는 모두 미러링이며, 코드의 최신성을 보증하지 않습니다.

## 설정

| 이름 | 설명 | 예시 값 | 기본 값 |
| ---- | ---- | ---- | ---- |
| `$wgLibertyMainColor` | `theme-color` 메타 설정 | `#4188F1` | `#4188F1` |
| `$wgTwitterAccount` | 트위터 카드 계정 설정 | `librewiki` | (없음) |
| `$wgLibertyOgLogo` | 오픈그래프 태그에 사용 될 이미지 설정 | `https://librewiki.net/images/6/6a/Libre_favicon.png` | `$wgLogo`의 값 |
| `$wgNaverVerification` | 네이버 사이트 도구 인증 코드 | (네이버에서 제공된 값) | (없음) |
| `$wgLibertyAdSetting` | 구글 애드센스 설정 | `array( 'client' => '(Google Adsense에서 제공한 값)', 'header' => '1234567890', 'right' => '0987654321' )` | (없음) |
| `$wgLibertyMaxRecent` | 사이드바 최근 변경에 등장하는 편집의 최대 개수 | `10` | `10` |

## 상단바
다음과 같은 형식을 따라서 `미디어위키:Liberty-Navbar` 문서에 작성해주세요.  

최상단 메뉴 : `* 아이콘 (선택) | 표시 될 문구 (선택) | Hover 상태에서 표시 될 문구 (선택) | 클릭 시 연결 될 주소 또는 문서명 (선택) | 단축키 (선택) | 커스텀 클래스 (선택)`  
하위 메뉴 : `** 아이콘 (선택) | 표시 될 문구 (선택) | Hover 상태에서 표시 될 문구 (선택) | 클릭 시 연결 될 주소 또는 문서명 (선택) | 단축키 (선택) | 커스텀 클래스 (선택)`  
최하위 메뉴 : `** 아이콘 (선택) | 표시 될 문구 (선택) | Hover 상태에서 표시 될 문구 (선택) | 클릭 시 연결 될 주소 또는 문서명 (선택) | 단축키 (선택) | 커스텀 클래스 (선택)`
* `아이콘`과 `표시 될 문구` 중 한가지는 설정되어 있어야 합니다.
* `Hover 상태에서 표시 될 문구`가 설정되어 있지 않다면 `표시 될 문구`로 자동 설정 됩니다.
* `표시 될 문구`나 `Hover 상태에서 표시 될 문구`를 설정 할 때 미디어위키 i18n 메시지의 이름을 작성하여 해당 i18n 메시지의 내용이 출력되게 할 수 있습니다. (예시: `recentchanges`를 적으면 `최근 바뀜` 출력)
* 단축키는 `Alt-Shift-(키)`로 사용 가능합니다.
* 단축키 설정 시 미디어위키에서 제공하는 기본 단축키와 겹치지 않도록 주의해주세요.
* 커스텀 클래스는 `,`로 구분하여 작성해주세요. (예시: `classA, classB`를 적어서 `classA`와 `classB` 클래스 추가)

예시는 [리브레 위키](https://librewiki.net/wiki/MediaWiki:Liberty-Navbar)에서 보실 수 있습니다. 
