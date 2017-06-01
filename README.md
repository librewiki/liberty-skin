# Liberty MediaWiki Skin

[리브레 위키](https://librewiki.net)의 기본 스킨입니다. 위키엔진 '리버티'의 기본 레이아웃이 될 예정입니다.

## 설정

| 이름                 	| 설명                                  	| 예시 값                                                                                                              	| 기본 값      	|
|----------------------	|---------------------------------------	|----------------------------------------------------------------------------------------------------------------------	|--------------	|
| `$wgLibertyMainColor`  	| `theme-color` 메타 설정                 	| `#4188F1`                                                                                                              	| `#4188F1`      	|
| `$wgTwitterAccount`    	| 트위터 카드 메타 설정                 	| `librewiki`                                                                                                            	| (없음)       	|
| `$wgLibertyOGLogo`     	| 오픈그래프 태그에 사용 될 이미지 설정 	| `https://librewiki.net/images/6/6a/Libre_favicon.png`                                                                  	| `$wgLogo`의 값 	|
| `$wgNaverVerification` 	| 네이버 사이트 도구 인증 코드          	| `0b20790abdd5720e293968109acb489744366ae9`                                                                             	| (없음)       	|
| `$wgLibertyAdSetting`  	| 광고 설정                             	| `array( "client" => "ca-pub-9526107750460253", "header" => "3627980722", "right" => "6581447128" )` 	| (없음)       	|
| `$wgLibertyMaxRecent`  	| 사이드바 최근 변경 최대 개수          	| `10`                                                                                                                   	| `10`           	|

## 상단바

다음과 같은 형식을 따라서 위키의 `MediaWiki:Liberty-Navbar` 문서에 작성해주세요.  
  
최상단 메뉴의 경우에는 `* (FontAwesome Icon Code) | 보여질 이름 | Hover 상태에 표시되는 설명(선택)`와 같이 설정해주시면 됩니다.  
하위 메뉴의 경우에는 `** 보여질 이름 | 연결 될 곳(문서 제목 또는 링크) | Hover 상태에 표시되는 설명(선택) | 단축키(선택)`와 같이 설정해주시면 됩니다.  
예시는 [리브레 위키](https://librewiki.net/wiki/MediaWiki:Liberty-Navbar)에서 보실 수 있습니다.
