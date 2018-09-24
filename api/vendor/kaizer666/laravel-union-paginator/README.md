# Laravel Union Paginator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kaizer666/laravel-union-paginator.svg?style=flat-square)](https://packagist.org/packages/kaizer666/laravel-union-paginator)
[![Licence](https://img.shields.io/packagist/l/kaizer666/laravel-union-paginator.svg?style=flat-square)](https://packagist.org/packages/kaizer666/laravel-union-paginator)
[![Build Status](https://travis-ci.org/kaizer666/LaravelUnionPaginator.svg?branch=master)](https://travis-ci.org/kaizer666/LaravelUnionPaginator)
[![Total Downloads](https://poser.pugx.org/kaizer666/laravel-union-paginator/d/total)](https://packagist.org/packages/kaizer666/laravel-union-paginator)
[![Latest Stable Version](https://poser.pugx.org/kaizer666/laravel-union-paginator/version)](https://packagist.org/packages/barryvdh/laravel-debugbar)

## Russian ReadMe
Russian ReadMe [here](README_ru.md)

## About
Paginator for questions, with Union

## Install

```$bash
composer require kaizer666/laravel-union-paginator
```

## Usage

```$php
use Union\UnionPaginator;

function test() {
    $data = Model::select(["id", "firstname"])
      ->whereIn("id", [1,2,3]);
    $data2 = OtherModel::select(["id", "firstname"])
      ->whereIn("id", [4,5,6])
      ->union($data);
    $paginator = new UnionPaginator();
    $response = $paginator
      ->setQuery($data2)
      ->setCurrentPage(28)
      ->setPerPage(20)
      ->getPaginate();
    $response["pagination"] = $paginator->links(); // html paginator
    $response["pagination_json"] = $paginator->linksJson(); // Json paginator
    return response()->json(
      $response
    );
}
```

## Testing

``` bash
$ composer test
```


## Credits

- [Maksim kovalyov](https://github.com/kaizer666)

## License

The MIT License (MIT)
