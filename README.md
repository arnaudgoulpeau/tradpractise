# TradPractise
Practise trad music !

Initialy, Fiddlehed (https://fiddlehed.com/) made up a Word practise sheet.
I decided to augment the principle with a web app because I think this is a great way to progress.

Create tunes with many informations, link it to thesession.org for irish trad music, to retreive ABC, genre and tone.
Associate a tune with files :
- MP3
- Youtube, Dailymotion, other web link
- Partition file
Arrange tunes in set, up to 5 tunes in a set

Create technics, the same way as tunes

Put tunes sets and technics in a practise

Retreive partitions in PDF format (with tablature) by requesting mandolintab.net (based on name)

Export all your mp3 in a specified folder (stays on server)

# Technical details :

Front end (Twig) to browse practise, tunes, technics
Admin Backend (EasyAdmin) to manage entities

No data provider, it's up to you to fill your DB since mp3 tunes could be under license.

# Known limitations
Info retreival focuses on irish trad music for now. The app get infos from thesession.org and mandolintab.net.
For other genres, scottish, canadian, or other, some adaptation will be needed. 

Feel free to contribute !

# Typical install

- Download code from github, or fork it.
- Put it under apache2.4
- I used a MariaDB 5 for data

# Usage

Create a folder under web : tunefiles
Create a folder under web : exportmp3

## Parameters needed

parameters.yml

    parameters:
        database_host: 127.0.0.1
        database_port: null
        database_name: yourdbname
        database_user: dbuser
        database_password: dbpass
        mailer_transport: smtp
        mailer_host: 127.0.0.1
        mailer_user: null
        mailer_password: null
        secret: c1a870ce16d9d9e812294d64a91a5bdfce1f009d
        app.path.tune_file_path: /tradpractise/web/tunefiles
        app.path.export_mp3_path: /tradpractise/web/exportmp3
        app.path.root_path: /volume1/web