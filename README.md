# emby-playlist-app
Web app you can locally host on the same server as your Emby setup to more easily create playlists.


"./vendor/bin/propel" diff
"./vendor/bin/propel" migrate
"./vendor/bin/propel" sql:build
"./vendor/bin/propel" model:build

composer dump-autoload

## .ENV
Windows
C:\\Users\\userName\\AppData\\Roaming\\Emby-Server\\data\\playlists