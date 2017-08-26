node-postgres-restapi
=====================

A bootstrap to create RESTful APIs with [Node.js](https://nodejs.org/), [Express](http://expressjs.com/) and [Postgres](https://www.postgresql.org/).

## Installation

```
npm install
```

## Postgres setup

You can find a dumb database under `data/startrek.sql`. You can import it with software like [Postico](https://eggerapps.at/postico/) (for OSX) or by running the following `psql` command in your terminal:

```
psql -f startrek.sql
```

You can configure your database connection in the `api/queries.js` file. The line:

```
var connectionString = 'postgres://localhost:5432/startrek'; // startrek is an example database name
```

## Usage

```
npm start
```

And check the server in:

or

```
node server.js
```

Test in the browser:

```
http://localhost:3000
```

If everything is ok, you should see:

```
{"status":"success","message":"Live long and prosper!"}
```

## Setting up your queries

- `api/queries.js`: functions and exports.
- `api/index.js`: connect the functions to the server permalinks.


## Credits

This bootstrap is based on [this tutorial](http://mherman.org/blog/2016/03/13/designing-a-restful-api-with-node-and-postgres/) for the queries' file structure. This repo is not using the express-framework to generate the code, so the code is cleaner. But you can check the tutorial for more information about how it works.

## License

You may use this code under the terms of the MIT License. See http://en.wikipedia.org/wiki/MIT_License for more information.

Copyright (C) 2017 Jordi Tost, and contributors

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
