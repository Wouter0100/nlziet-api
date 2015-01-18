NLZiet API and OAuth docs
=========================
Because there wasn't any documentation about NLZiet's API/OAuth, I've decided get a closer look at there way of working :-).

I've used those API's in a private project of mine. Those instructions do not include playing videos and such. Only receiving information through there API's.

**Please note:** I don't have any permissions and only used it for a private project. It's up to you what you're doing with it :-). And, NLZiet may update there systems at any time, at which point those instructions may not work anymore.

OAauth
------
* Consumer key: `Removed, you may find out yourself, or contact me.`
* Consumer secret: `Removed, you may find out yourself, or contact me.`

See the `examples/authenticate.php` file for an example. I may write it down here in the future.

API
---
I may have missed some API methods, feel free to add them :-).

#### Validate access token
To check if an access token is still vali. I think it returns the time of expire. You don't need anything extra, just a GET request.

Request URL: `http://api.nlziet.nl/v1/AccessTokenStatus/<ACCESS_TOKEN>`

#### Get User Playlists
It seems, at the current time, default users have 2 playlists:
* Favorites ("WatchLater", I think just our favorites, name seems obvious, but type isn't)
* Watched ("Watched", maybe a playlist of thinks you've watched in the past?)

At the time of writing, only the Favorites playlist seems to being called (using the Get Playlist). I think the Watched playlist isn't implemented yet.

Request URL: `http://api.nlziet.nl/v1/userplaylists` with the OAuth header (you could be using `$oauth->fetch` in the authenticate example)  
It may return something like (JSON):
```
[{
	"Id": <ID>,
	"Title": "Favorieten",
	"Type": "WatchLater"
}, {
	"Id": <ID, in my case 1 more then the ID above>,
	"Title": "Bekeken",
	"Type": "Watched"
}]
```

#### Get playlist
Using this request you receive the content of a specified playlist.

Request URL: `http://api.nlziet.nl/v1/userplaylists/<ID>`  
It may return something like (JSON), I tried to describe everything:
```
{
	"Items": [{
		"Id": <ID>,
		"Added": "<YYYY-MM-DD'T'hh:mm:ss.s>",
		"AddedByUser": false,
		"IsLastSeriesEpisode": true,
		"NewAndUnwatched": false,
		"ContentIdDeelnemer": "<IDK>",
		"ScupDeeplink": "<URL to item>",
		"ProgrammaOmschrijving": "<Program description>",
		"ProgrammaAfbeelding": "<thumbnail>",
		"AfleveringTitel": "Afl. 3",
		"AfleveringVolgnummer": 3,
		"Uitzenddatum": "<YYYY-MM-DD'T'hh:mm:ss>",
		"UitzenddatumGids": "<YYYY-MM-DD'T'hh:mm:ss>",
		"Zender": "<Transmitter>",
		"Duur": <In seconds?>,
		"Genres": [],
		"Omroepen": [],
		"NICAM": "ALT",
		"BeschikbaarheidsWindow": "<YYYY-MM-DD'T'hh:mm:ss>",
		"BeschikbaarVanaf": "<YYYY-MM-DD'T'hh:mm:ss>",
		"Deelnemer": "R",
		"DeelnemerData": null,
		"ContentType": "P",
		"SerieId": <Serie ID>,
		"ModifiedOn": "<YYYY-MM-DD'T'hh:mm:ss.s>",
		"CreatedOn": "<YYYY-MM-DD'T'hh:mm:ss.s>",
		"DRM": false,
		"OsRestricties": "None",
		"IsClip": false,
		"SerieIdDeelnemer": "<User ID?>",
		"ContentId": <Content ID>,
		"ProgrammaTitel": "<Program name>",
		"ProgrammaId": "<User ID?>",
		"MetaDataUrl": "<URL of meta data>",
		"ComscoreTellerDto": null
	}],
	"Id": <ID>,
	"Title": "Favorieten",
	"Type": "WatchLater"
}```

## To be continued..