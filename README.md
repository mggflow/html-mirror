# Web page mirror

## About

Mirror the full html of the page.

## Installation

1. Download ``scripts`` directory on aim machine.
2. Run ``sudo sh scripts/install.sh -u0 -g0 -d"/path/to/dir"`` (u - user id, g - group id, d - path to installation dir)
3. Change docker config in ``docker-compose.yml``
4. Change ``env.prod`` and ``env.dev`` according to exists ``.env`` or ``.env.example``

## Usage

Move to directory with app

```
cd /path/to/dir
```

Docker compose

```
docker compose up -d
```

Use route ``/reflect`` by app port with any type request

```
http://127.0.0.1:8009/reflect?url=https://google.com&waitTime=3&preWait=0&chromeArgs[0]=--lang=ru-RU&chromeArgs[1]=--accept-lang=ru-RU
```

Params:

1) ``url`` - Required. Url of page which html we want to obtain.
2) ``waitTime`` - Max wait time for page loading.
3) ``preWait`` - Flag marking necessity to wait before page load check.
4) ``chromeArgs`` - Array of Chrome args.


