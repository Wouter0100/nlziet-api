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

Request URL: `http://api.nlziet.nl/v1/userplaylists/<ID>` with the OAuth header (you could be using `$oauth->fetch` in the authenticate example)

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
}
```

### Get tipfeed
This request will give you a `tipfeed` (recommended series) per `deelnemer` (NPO, Zien, RTLXL).

Request URL: `http://api.nlziet.nl/v1/tipfeed?amount=<Amount of series per deelnemer>` with the OAuth header (you could be using `$oauth->fetch` in the authenticate example)

It may return something like (JSON, amount = 1), see `get playlist` for details:
```
[{
	"Title": "De slag om de klerewereld",
	"ImageUrl": "https://nlzietprodstorage.blob.core.windows.net/feeditems/thumbnail/DeelnemerN/54b8e4c48fe12_904x508.png",
	"MetadataItem": {
		"ContentIdDeelnemer": "VPWON_1231623",
		"ScupDeeplink": "http://npoplus.nl/play/de_slag_om_de_klerewereld/2015-01-02/VPWON_1231623/152249",
		"ProgrammaOmschrijving": "Drieluik over onveilige fabrieken en barre werkomstandigheden die al decennia de textielindustrie kenmerken. Na de Rana Plaza ramp in Bangladesh in april 2013 beloofden grote kledingmerken en -ketens echter beterschap. Roland Duong en Teun van de Keuken onderzoeken hoe het er in textielindustrie nu werkelijk aan toe gaat. Maar alleen een handelaar heeft toegang tot de krochten van de textielketen, dus gaat Teun undercover. Aan onze kleren kleeft al tientallen jaren veel ellende. Onveilige fabrieken, barre werkomstandigheden, uitbuiting en kinderarbeid zijn eerder regel dan uitzondering. De ramp in Rana Plaza leek de druppel. Grote kledingmerken en modeketens tekenden convenanten en akkoorden, werden partners met NGO's en vermelden nu vol trots hoe verantwoord ze werken. Maar klopt dit wel? Teun van de Keuken en Roland Duong maken in De slag om de klerewereld de onzichtbare problemen in de mode-industrie zichtbaar.",
		"ProgrammaAfbeelding": "thumbnail/VPWON_1231623.png",
		"AfleveringTitel": "De slag om de klerewereld",
		"AfleveringVolgnummer": 0,
		"Uitzenddatum": "2015-01-02T21:10:00",
		"UitzenddatumGids": "2015-01-02T00:00:00",
		"Zender": "NED2",
		"Duur": 0,
		"Genres": [],
		"Omroepen": [],
		"NICAM": "",
		"BeschikbaarheidsWindow": "2016-01-03T20:52:49",
		"BeschikbaarVanaf": "2015-01-02T20:52:49",
		"Deelnemer": "N",
		"DeelnemerData": null,
		"ContentType": "P",
		"SerieId": 7537,
		"ModifiedOn": "2015-01-02T21:21:07.66",
		"CreatedOn": "2015-01-02T21:20:08.977",
		"DRM": false,
		"OsRestricties": "None",
		"IsClip": false,
		"SerieIdDeelnemer": "4117",
		"ContentId": 152249,
		"ProgrammaTitel": "De slag om de klerewereld",
		"ProgrammaId": "4117",
		"MetaDataUrl": "/video/152249",
		"ComscoreTellerDto": null
	},
	"ContentIdDeelnemer": "VPWON_1231623",
	"Deelnemer": "DeelnemerN",
	"DeelnemerShort": "N"
}, {
	"Title": "Divorce",
	"ImageUrl": "https://nlzietprodstorage.blob.core.windows.net/feeditems/thumbnail/DeelnemerR/b828f217-c707-37da-8843-e82776397ff6.png",
	"MetadataItem": {
		"ContentIdDeelnemer": "b828f217-c707-37da-8843-e82776397ff6",
		"ScupDeeplink": "http://nlziet.rtlxl.nl/#!/play/144918",
		"ProgrammaOmschrijving": "Davids secretaresse Els is 25 jaar in dienst en verwacht een bijzonder cadeau. David is het straal vergeten, maar maakt het ruimschoots goed. Joris maakt zich grote zorgen over Joyce als moeder. En de drie vrienden ontpoppen zich als kunstrovers.",
		"ProgrammaAfbeelding": "thumbnail/b828f217-c707-37da-8843-e82776397ff6.png",
		"AfleveringTitel": "Afl. 3",
		"AfleveringVolgnummer": 3,
		"Uitzenddatum": "2015-01-18T20:55:00",
		"UitzenddatumGids": "2015-01-18T00:00:00",
		"Zender": "RTL4",
		"Duur": 2615,
		"Genres": [],
		"Omroepen": [],
		"NICAM": "12ST",
		"BeschikbaarheidsWindow": "2016-03-21T20:30:00",
		"BeschikbaarVanaf": "2015-01-11T19:55:00",
		"Deelnemer": "R",
		"DeelnemerData": null,
		"ContentType": "P",
		"SerieId": 2,
		"ModifiedOn": "2015-01-18T05:52:50.157",
		"CreatedOn": "2014-11-28T15:56:32.107",
		"DRM": false,
		"OsRestricties": "None",
		"IsClip": false,
		"SerieIdDeelnemer": "277291",
		"ContentId": 144918,
		"ProgrammaTitel": "Divorce",
		"ProgrammaId": "277291",
		"MetaDataUrl": "/video/144918",
		"ComscoreTellerDto": null
	},
	"ContentIdDeelnemer": "b828f217-c707-37da-8843-e82776397ff6",
	"Deelnemer": "DeelnemerR",
	"DeelnemerShort": "R"
}, {
	"Title": "Gouden Bergen",
	"ImageUrl": "https://nlzietprodstorage.blob.core.windows.net/feeditems/thumbnail/DeelnemerS/a79b4d901aebdb11a113d5d694c3c3bb9b67537d.png",
	"MetadataItem": {
		"ContentIdDeelnemer": "HQKxTDANQXnP",
		"ScupDeeplink": "http://nlziet.kijk.nl/video/HQKxTDANQXnP",
		"ProgrammaOmschrijving": "Een komisch drama over vijf vrouwen in crisis, die alles op alles zetten om naar hun stand te kunnen blijven leven.",
		"ProgrammaAfbeelding": "thumbnail/HQKxTDANQXnP.png",
		"AfleveringTitel": "Gouden Bergen: Aflevering 2",
		"AfleveringVolgnummer": 2,
		"Uitzenddatum": "2015-01-14T20:30:00",
		"UitzenddatumGids": "2015-01-14T00:00:00",
		"Zender": "SBS6",
		"Duur": 2629,
		"Genres": [],
		"Omroepen": [],
		"NICAM": "",
		"BeschikbaarheidsWindow": "2016-01-14T19:30:00",
		"BeschikbaarVanaf": "2015-01-14T20:27:00",
		"Deelnemer": "S",
		"DeelnemerData": null,
		"ContentType": null,
		"SerieId": 7566,
		"ModifiedOn": "2015-01-15T00:06:53.47",
		"CreatedOn": "2015-01-14T23:12:21.267",
		"DRM": false,
		"OsRestricties": "None",
		"IsClip": false,
		"SerieIdDeelnemer": "goudenbergen",
		"ContentId": 155111,
		"ProgrammaTitel": "Gouden Bergen",
		"ProgrammaId": "goudenbergen",
		"MetaDataUrl": "/video/155111",
		"ComscoreTellerDto": null
	},
	"ContentIdDeelnemer": "HQKxTDANQXnP",
	"Deelnemer": "DeelnemerS",
	"DeelnemerShort": "S"
}]
```

### Autocomplete search
Using this request you can search in there serie database, using "autocomplete". (Keywords?).

Request URL: `http://api.nlziet.nl/v1/autocomplete?expandlist=true&expand=true&maxresults=5&searchterm=3Onderzoekt&deelnemer=&deelnemerresults=5` with the OAuth header (you could be using `$oauth->fetch` in the authenticate example)

It may return something like (JSON), see `get playlist` for details:
```
{
	"SearchLinks": [],
	"Metadata": {
		"Items": [{
			"NrOfHitsForSerie": 20,
			"ContentIdDeelnemer": "VPWON_1235598",
			"ScupDeeplink": "http://npoplus.nl/play/3onderzoekt/2014-12-17/VPWON_1235598/149794",
			"ProgrammaOmschrijving": "3Onderzoekt-presentator Danny neemt zijn collega Johan mee naar Libanon om Kerst te vieren in Beiroet. Danny laat Johan de twee gezichten van zijn geboorteland zien. De oorlog, de trauma's en de armoede en aan de andere kant de extravagante uitgaansscene, de westerse universiteiten en het luxueuze skigebied in het Libanongebergte. Samen bezoeken ze een christelijk weeshuis om kerstcadeaus te brengen, gaan ze skiën in Faraya, nuttigen ze het kerstdiner bij een arm Libanees gezin, duiken ze het nachtleven van Beiroet in en bezoeken ze Syrische Palestijnse vluchtelingen. Een speciale aflevering die je niet wilt missen!",
			"ProgrammaAfbeelding": "thumbnail/VPWON_1235598.png",
			"AfleveringTitel": "Kerst in Beiroet",
			"AfleveringVolgnummer": 0,
			"Uitzenddatum": "2014-12-17T22:20:00",
			"UitzenddatumGids": "2014-12-17T00:00:00",
			"Zender": "NED3",
			"Duur": 0,
			"Genres": ["Informatief"],
			"Omroepen": ["EO"],
			"NICAM": "",
			"BeschikbaarheidsWindow": "2015-12-18T21:50:25",
			"BeschikbaarVanaf": "2014-12-17T21:50:25",
			"Deelnemer": "N",
			"DeelnemerData": null,
			"ContentType": "P",
			"SerieId": 0,
			"ModifiedOn": "2014-12-17T22:50:17",
			"CreatedOn": "2014-12-17T22:18:04",
			"DRM": false,
			"OsRestricties": "None",
			"IsClip": false,
			"ContentId": 149794,
			"ProgrammaTitel": "3Onderzoekt",
			"ProgrammaId": "1766",
			"MetaDataUrl": "/video/149794",
			"ComscoreTellerDto": null
		}],
		"Title": null
	}
}
```

Contact me
----------
- Twitter: @wouter0100
- Email me: wouter@wouter0100.nl