# LobbySystem
LobbySystem alles einstellbar / A fully configurable Lobby System by iTzFreeHD
## Terms and Conditions:
- This plugin is free to use, you are not allowed to sell it or get any payment for it.
- You are not allowed to claim this plugin or any parts of it as yours
- You are not allowed to change the plugin.yml or any parts of it
- You are not allowed to publish this plugin without giving credits(Link to this Repo, Link to Hyroxing account...)
### With downloading the plugin, you agree to the points above
--------------------
### Download .phar:
[COMING SOON]
- [![Download .phar](https://poggit.pmmp.io/ci/Hyroxing/LobbySystem/LobbySystem-iTzFreeHDv2)](https://poggit.pmmp.io/ci/Hyroxing/LobbySystem/LobbySystem-iTzFreeHDv2)
--------------------
## German:

### Achtung:
- Bevor du das Plugin beginnst einzustellen lese dir den Aspekt [Wichtig](#wichtig) durch!

### Installieren:
- Das plugin in den Plugin ordner deines Servers kopieren. 
- Den Server restarten. 
- Fertig!
- Zusätzlich kannst du noch [AddOns](#addons) instalieren.
- Mehr hilfe unter [Hilfe](#hilfe)

### Beschreibung:
- Das LobbySystem ist ein Plugin welches den Benutzern das einstellen der Items einfacher macht. So kann man jedes einzelne Item einzeln in der Config einstellen. Außerdem lässt sich über die "action"-Funktion etwas ausführen z.B. ```action:  cmd:gamemode 1 ```.

### Eigenschaften:
- [x] Alles einstellbar
- [x] No-Hunger
- [x] No-Damage
- [x] No-Drop
- [x] No-Void
- [x] No-Permission-MSG

### Hilfe?
- Wenn du hilfe brachst schau dir den Aspekt [Guide](#guide) oder [Wichtig](#wichtig) einmal (oder mehrmals) genau an.
- Wenn das oben genannte dir nocht hilft kannst du uns über den Discord kontaktieren.
 Link: https://discord.gg/Kna6D9f
- [Tutorial-Video](#tutorial-video)
- [AddOns](#addons)
------------
### Wichtig:
- Slots sind von 0-8 durchnummeriert
- Bitte beachte das ```Teleporter:``` gleich wie ```name: §6Teleporter``` nur das bei dem "name" Farbsymbole gesetzt werden dürfen. Falls das nicht der Fall ist können Fehler entstehen. In folgenden Versionen wird dieses Problem behoben sein!

#### Richtig:
```php
Main:
  Teleporter:
    name: §6Teleporter
```
#### Falsch:
```php
Main:
  Test:
    name: §6Teleporter
```
-----
### Guide:

- Actions:

| Actions  | Benutzung | Bedeutung |
| ------------- | ------------- |------------- | 
| msg | action: 'msg: Hello World' | Sendet dem Spieler eine Nachricht |
| cmd | action: 'cmd:freeparticle' | Führt einen befehl für den Spieler aus |
| menu | action: 'menu:Main' | Öffnet das jeweils angegebene Menu |
| tp | action: 'tp:X:Y:Z:world' | Teleportiert den Spieler zu den angegebenen Kordinaten |
| tp-spawn | action: 'tp:spawn' | Teleportiert den Spieler zum Weltpawm |

- Permissions:

| Permission | Command | Beschreibung |
| ------------- | ------------- |------------- | 
| lobby.fly | fly | Aktiviert / Deaktiveirt den Flugmodus |
| lobby.build | build | Aktiviert / Deaktiveirt den Buildmodus |
| - | lbmain | Gibt dem Spieler die Main Items |

### AddOns:
- [Particle](https://github.com/Hyroxing/LobbyParticle-AddON)
- [PlayerHider](https://github.com/Hyroxing/PlayerHider-AddOn)
-----
## Items.yml
```php
---
Build-Perms: lobby.build
noHunger: true
noDamage: true
noDrop: true
noVoid: true
NoPermission: §cDu hast keine Rechte
JoinMenu: Main
Main:
  Teleporter:
    name: §6Teleporter
    id: "345:0:1"
    slot: 3
    action: menu:Info
    permissions: ""
  Build:
    name: §6Build
    id: "2:0:1"
    slot: 5
    action: cmd:build
    permissions: lobby.build
  Tools:
    name: §6Tools
    id: "396:0:1"
    slot: 8
    action: cmd:freeparticle
    permissions: ""
Info:
  Info:
    name: §bInfo
    id: "340:0:1"
    slot: 0
    action: 'msg: §bGehe auf github.com/Hyroxing um mehr Infos zu den Einstellungen
      zu erhalten'
    permissions: lobby.info
  Spawn:
    name: §6Spawn
    id: "378:0:1"
    slot: 4
    action: tp:spawn
    permissions: ""
  Exit:
    name: §cExit
    id: "351:1:1"
    slot: 8
    action: menu:Main
    permissions: ""
...
```
### Tutorial-Video
[![Alt text](https://img.youtube.com/vi/Lfy3vUrnxRw/maxresdefault.jpg)](https://www.youtube.com/watch?v=Lfy3vUrnxRw)
